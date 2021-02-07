<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query\Filter;

use Arp\DoctrineQueryFilter\Filter\FilterInterface;
use Arp\DoctrineQueryFilter\Filter\FilterManagerInterface;
use Arp\DoctrineQueryFilter\QueryFilterManagerInterface;
use Laminas\ServiceManager\AbstractPluginManager;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query
 */
class FilterManager extends AbstractPluginManager implements FilterManagerInterface
{
    /**
     * @var string
     */
    protected $instanceOf = FilterInterface::class;

    /**
     * @param QueryFilterManagerInterface $manager
     * @param string                      $name
     * @param array                       $options
     *
     * @return FilterInterface
     */
    public function create(QueryFilterManagerInterface $manager, string $name, array $options = []): FilterInterface
    {
        return $this->build(
            $name,
            array_replace_recursive($options, ['query_filter_manager' => $manager])
        );
    }
}
