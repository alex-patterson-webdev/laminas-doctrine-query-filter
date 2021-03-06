<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query\Filter;

use Arp\LaminasDoctrine\Query\Constant\WhereType;
use Arp\LaminasDoctrine\Query\Exception\QueryFilterException;
use Arp\LaminasDoctrine\Query\Exception\QueryFilterManagerException;
use Arp\LaminasDoctrine\Query\Metadata\MetadataInterface;
use Arp\LaminasDoctrine\Query\QueryBuilderInterface;
use Doctrine\ORM\Query\Expr\Andx as DoctrineAndX;
use Doctrine\ORM\Query\Expr\Andx as DoctrineOrX;
use Doctrine\ORM\Query\Expr\Composite;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query\Filter
 */
abstract class AbstractComposite extends AbstractFilter
{
    /**
     * @param QueryBuilderInterface $queryBuilder
     *
     * @return Composite
     */
    abstract protected function createComposite(QueryBuilderInterface $queryBuilder): Composite;

    /**
     * @param QueryBuilderInterface $queryBuilder
     * @param MetadataInterface     $metadata
     * @param array                 $criteria
     *
     * @throws QueryFilterException
     */
    public function filter(
        QueryBuilderInterface $queryBuilder,
        MetadataInterface $metadata,
        array $criteria
    ): void {
        if (empty($criteria['conditions'])) {
            return;
        }

        $qb = $queryBuilder->createQueryBuilder();

        try {
            $this->queryFilterManager->filter($qb, $metadata->getName(), ['filters' => $criteria['conditions']]);
        } catch (QueryFilterManagerException $e) {
            throw new QueryFilterException(
                sprintf('Failed to construct query filter \'%s\' conditions: %s', static::class, $e->getMessage()),
                $e->getCode(),
                $e
            );
        }

        $parts = $qb->getQueryParts();
        if (
            !isset($parts['where'])
            || (!$parts['where'] instanceof DoctrineAndx || !$parts['where'] instanceof DoctrineOrX)
        ) {
            return;
        }

        $compositeExpr = $this->createComposite($queryBuilder);
        $compositeExpr->addMultiple($parts['where']->getParts());

        if (!isset($criteria['where']) || WhereType::AND === $criteria['where']) {
            $queryBuilder->andWhere($compositeExpr);
        } else {
            $queryBuilder->orWhere($compositeExpr);
        }

        $queryBuilder->mergeParameters($qb);
    }
}
