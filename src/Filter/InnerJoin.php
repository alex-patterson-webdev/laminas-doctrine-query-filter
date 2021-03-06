<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query\Filter;

use Arp\LaminasDoctrine\Query\QueryBuilderInterface;
use Doctrine\ORM\Query\Expr\Base;
use Doctrine\ORM\Query\Expr\Composite;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query\Filter
 */
final class InnerJoin extends AbstractJoin
{
    /**
     * @param QueryBuilderInterface      $queryBuilder
     * @param string                     $fieldName
     * @param string                     $alias
     * @param null|string|Composite|Base $condition
     * @param string                     $joinType
     * @param string|null                $indexBy
     */
    protected function applyJoin(
        QueryBuilderInterface $queryBuilder,
        string $fieldName,
        string $alias,
        $condition = null,
        string $joinType = Join::WITH,
        ?string $indexBy = null
    ): void {
        $queryBuilder->innerJoin($fieldName, $alias, $joinType, $condition, $indexBy);
    }
}
