<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query\Filter;

use Arp\LaminasDoctrine\Query\Exception\QueryFilterException;
use Arp\LaminasDoctrine\Query\Metadata\MetadataInterface;
use Arp\LaminasDoctrine\Query\QueryBuilderInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query\Filter
 */
interface FilterInterface
{
    /**
     * @param QueryBuilderInterface $queryBuilder
     * @param MetadataInterface     $metadata
     * @param array                 $criteria
     *
     * @throws QueryFilterException
     */
    public function filter(QueryBuilderInterface $queryBuilder, MetadataInterface $metadata, array $criteria): void;
}
