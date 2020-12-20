<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query\Filter;

use Arp\LaminasDoctrine\Query\Exception\InvalidArgumentException;
use Arp\LaminasDoctrine\Query\Exception\QueryFilterException;
use Arp\LaminasDoctrine\Query\Exception\QueryFilterManagerException;
use Arp\LaminasDoctrine\Query\Metadata\MetadataInterface;
use Arp\LaminasDoctrine\Query\QueryBuilderInterface;
use Doctrine\ORM\Mapping\MappingException;
use Doctrine\ORM\Query\Expr\Andx as DoctrineAndX;
use Doctrine\ORM\Query\Expr\Base;
use Doctrine\ORM\Query\Expr\Composite;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query\Expr\Orx as DoctrineOrX;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query\Filter
 */
abstract class AbstractJoin extends AbstractFilter
{
    public const JOIN_INNER = 'innerJoin';
    public const JOIN_LEFT = 'leftJoin';

    /**
     * @param QueryBuilderInterface      $queryBuilder
     * @param string                     $fieldName
     * @param string                     $alias
     * @param null|string|Composite|Base $condition
     * @param string                     $joinType
     * @param string|null                $indexBy
     */
    abstract protected function applyJoin(
        QueryBuilderInterface $queryBuilder,
        string $fieldName,
        string $alias,
        $condition = null,
        string $joinType = Join::WITH,
        ?string $indexBy = null
    ): void;

    /**
     * @param QueryBuilderInterface $queryBuilder
     * @param MetadataInterface     $metadata
     * @param array                 $criteria
     *
     * @throws InvalidArgumentException
     * @throws QueryFilterException
     */
    public function filter(QueryBuilderInterface $queryBuilder, MetadataInterface $metadata, array $criteria): void
    {
        $fieldName = $this->resolveFieldName($criteria);
        $mapping = $this->getAssociationMapping($metadata, $fieldName);

        $alias = $criteria['alias'] ?? null;
        if (null === $alias) {
            throw new InvalidArgumentException(
                sprintf('The required \'alias\' criteria value is missing for filter \'%s\'', static::class)
            );
        }

        $conditions = $criteria['conditions'] ?? [];
        $condition = null;

        if (is_object($conditions)) {
            $condition = $conditions;
        } elseif (is_array($conditions) && !empty($conditions)) {
            $tempQueryBuilder = $queryBuilder->createQueryBuilder();
            $this->filterJoinConditions($tempQueryBuilder, $mapping['targetEntity'], $alias, $conditions);
            $condition = $this->mergeJoinConditions($queryBuilder, $tempQueryBuilder);
        }

        $parentAlias = $criteria['parent_alias'] ?? 'entity';
        $this->applyJoin(
            $queryBuilder,
            $parentAlias . '.' . $fieldName,
            $alias,
            $condition,
            $criteria['join_type'] ?? Join::WITH,
            $criteria['index_by'] ?? null
        );
    }

    /**
     * @param array  $conditions
     * @param string $alias
     *
     * @return array
     */
    private function createJoinFilters(array $conditions, string $alias): array
    {
        // Use the join alias as the default alias for conditions
        foreach ($conditions as $index => $condition) {
            if (is_array($condition) && empty($condition['alias'])) {
                $conditions[$index]['alias'] = $alias;
            }
        }

        return [
            'filters' => [
                [
                    'name'       => AndX::class,
                    'conditions' => $conditions,
                    'where'      => $criteria['filters']['where'] ?? null,
                ],
            ],
        ];
    }

    /**
     * @param MetadataInterface $metadata
     * @param string            $fieldName
     *
     * @return array
     *
     * @throws InvalidArgumentException
     */
    private function getAssociationMapping(MetadataInterface $metadata, string $fieldName): array
    {
        try {
            return $metadata->getAssociationFiledMapping($fieldName);
        } catch (MappingException $e) {
            throw new InvalidArgumentException(
                sprintf(
                    'Failed to load association field mapping for field \'%s::%s\' in filter \'%s\'',
                    $metadata->getName(),
                    $fieldName,
                    static::class
                )
            );
        }
    }

    /**
     * @param QueryBuilderInterface $qb
     * @param string                $targetEntity
     * @param string                $alias
     * @param array                 $conditions
     *
     * @throws QueryFilterException
     */
    private function filterJoinConditions(
        QueryBuilderInterface $qb,
        string $targetEntity,
        string $alias,
        array $conditions
    ): void {
        try {
            $this->queryFilterManager->filter(
                $qb,
                $targetEntity,
                $this->createJoinFilters($conditions, $alias)
            );
        } catch (QueryFilterManagerException $e) {
            throw new QueryFilterException(
                sprintf(
                    'Failed to apply query filter \'%s\' conditions for target entity \'%s\': %s',
                    static::class,
                    $targetEntity,
                    $e->getMessage()
                ),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @param QueryBuilderInterface $queryBuilder
     * @param QueryBuilderInterface $qb
     *
     * @return DoctrineAndX|DoctrineOrX|null
     */
    private function mergeJoinConditions(QueryBuilderInterface $queryBuilder, QueryBuilderInterface $qb): ?Composite
    {
        $parts = $qb->getQueryParts();

        if (!isset($parts['where'])) {
            return null;
        }

        if ($parts['where'] instanceof DoctrineAndx) {
            $condition = $queryBuilder->expr()->andX();
        } elseif ($parts['where'] instanceof DoctrineOrX) {
            $condition = $queryBuilder->expr()->orX();
        } else {
            return null;
        }

        $condition->addMultiple($parts['where']->getParts());
        $queryBuilder->mergeParameters($qb);

        return $condition;
    }
}
