<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrineQueryFilter\Filter;

use Arp\DoctrineQueryFilter\Filter\FilterFactoryInterface;
use Arp\DoctrineQueryFilter\Filter\FilterInterface;
use Arp\DoctrineQueryFilter\QueryFilterManagerInterface;
use Laminas\ServiceManager\AbstractPluginManager;
use Psr\Container\ContainerExceptionInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrineQueryFilter
 */
class FilterManager extends AbstractPluginManager implements FilterFactoryInterface
{
    /**
     * @var class-string<FilterInterface>
     */
    protected $instanceOf = FilterInterface::class;

    /**
     * @param QueryFilterManagerInterface $manager
     * @param string                      $name
     * @param array<mixed>                $options
     *
     * @return FilterInterface
     *
     * @throws ContainerExceptionInterface
     */
    public function create(QueryFilterManagerInterface $manager, string $name, array $options = []): FilterInterface
    {
        return $this->build(
            $name,
            array_replace_recursive($options, ['query_filter_manager' => $manager])
        );
    }
}
