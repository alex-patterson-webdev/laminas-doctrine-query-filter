<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query;

use Arp\LaminasDoctrine\Query\Exception\QueryFilterException;
use Arp\LaminasDoctrine\Query\Exception\QueryFilterManagerException;
use Arp\LaminasDoctrine\Query\Filter\FilterInterface;
use Arp\LaminasDoctrine\Query\Filter\FilterManager;
use Arp\LaminasDoctrine\Query\Metadata\Metadata;
use Arp\LaminasDoctrine\Query\Metadata\MetadataInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query
 */
class QueryFilterManager
{
    /**
     * @var FilterManager
     */
    private FilterManager $filterManager;

    /**
     * @param FilterManager $filterManager
     */
    public function __construct(FilterManager $filterManager)
    {
        $this->filterManager = $filterManager;
    }

    /**
     * Apply the query filters to the provided query builder instance
     *
     * @param DoctrineQueryBuilder|QueryBuilderInterface $queryBuilder
     * @param string                                     $entityName
     * @param array                                      $criteria
     *
     * @throws QueryFilterManagerException
     */
    public function filter($queryBuilder, string $entityName, array $criteria): void
    {
        if (empty($criteria['filters']) || !is_array($criteria['filters'])) {
            return;
        }

        $queryBuilder = $this->getQueryBuilder($queryBuilder);
        $metadata = $this->createMetadataProxy($queryBuilder->getEntityManager(), $entityName);

        foreach ($criteria['filters'] as $data) {
            try {
                $this->applyFilter($queryBuilder, $metadata, $data);
            } catch (QueryFilterException $e) {
                throw new QueryFilterManagerException(
                    sprintf(
                        'An error occurred while attempting to apply the query filters for entity \'%s\': %s',
                        $entityName,
                        $e->getMessage()
                    ),
                    $e->getCode(),
                    $e
                );
            }
        }
    }

    /**
     * @param QueryBuilderInterface|DoctrineQueryBuilder $queryBuilder
     *
     * @return QueryBuilderInterface
     *
     * @throws QueryFilterManagerException
     */
    private function getQueryBuilder($queryBuilder): QueryBuilderInterface
    {
        if ($queryBuilder instanceof DoctrineQueryBuilder) {
            $queryBuilder = $this->createQueryBuilderProxy($queryBuilder);
        }

        if (!$queryBuilder instanceof QueryBuilderInterface) {
            throw new QueryFilterManagerException(
                sprintf(
                    'The \'queryBuilder\' argument must be an object of type \'%s\' or \'%s\'; '
                    . '\'%s\' provided in \'%s\'',
                    QueryBuilderInterface::class,
                    DoctrineQueryBuilder::class,
                    is_object($queryBuilder) ? get_class($queryBuilder) : gettype($queryBuilder),
                    static::class
                )
            );
        }

        return $queryBuilder;
    }

    /**
     * @param QueryBuilderInterface $queryBuilder
     * @param MetadataInterface     $metadata
     * @param array                 $data
     *
     * @throws QueryFilterException
     */
    private function applyFilter(QueryBuilderInterface $queryBuilder, MetadataInterface $metadata, array $data): void
    {
        $filterName = $data['name'] ?? null;

        if (empty($filterName)) {
            throw new QueryFilterException(
                sprintf('The required \'name\' query filter configuration option is missing in \'%s\'', __METHOD__)
            );
        }

        $filter = $this->createFilter($filterName, $data['options'] ?? []);
        $filter->filter($queryBuilder, $metadata, $data);
    }

    /**
     * @param string $name
     * @param array  $options
     *
     * @return FilterInterface
     *
     * @throws QueryFilterException
     */
    private function createFilter(string $name, array $options = []): FilterInterface
    {
        try {
            /** @var FilterInterface $filter */
            return $this->filterManager->build(
                $name,
                array_replace_recursive($options, ['query_filter_manager' => $this])
            );
        } catch (\Throwable $e) {
            throw new QueryFilterException(
                sprintf('Failed to build query filter \'%s\': %s', $name, $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @param EntityManager $entityManager
     * @param string        $entityName
     *
     * @return MetadataInterface
     *
     * @throws QueryFilterManagerException
     */
    private function createMetadataProxy(EntityManager $entityManager, string $entityName): MetadataInterface
    {
        try {
            return new Metadata($entityManager->getClassMetadata($entityName));
        } catch (\Throwable $e) {
            throw new QueryFilterManagerException(
                sprintf('Failed to fetch entity metadata for class \'%s\': %s', $entityName, $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @param DoctrineQueryBuilder $queryBuilder
     *
     * @return QueryBuilderInterface
     */
    private function createQueryBuilderProxy(DoctrineQueryBuilder $queryBuilder): QueryBuilderInterface
    {
        return new QueryBuilder($queryBuilder);
    }
}
