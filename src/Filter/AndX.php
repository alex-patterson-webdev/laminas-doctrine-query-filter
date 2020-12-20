<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query\Filter;

use Arp\LaminasDoctrine\Query\QueryBuilderInterface;
use Doctrine\ORM\Query\Expr\Composite;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query\Filter
 */
class AndX extends AbstractComposite
{
    /**
     * @param QueryBuilderInterface $queryBuilder
     *
     * @return Composite
     */
    protected function createComposite(QueryBuilderInterface $queryBuilder): Composite
    {
        return $queryBuilder->expr()->andX();
    }
}
