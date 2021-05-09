<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrineQueryFilter\Sort;

use Arp\DoctrineQueryFilter\QueryFilterManagerInterface;
use Arp\DoctrineQueryFilter\Sort\SortFactoryInterface;
use Arp\DoctrineQueryFilter\Sort\SortInterface;
use Laminas\ServiceManager\AbstractPluginManager;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrineQueryFilter\Sort
 */
final class SortManager extends AbstractPluginManager implements SortFactoryInterface
{
    /**
     * @var string
     */
    protected $instanceOf = SortInterface::class;

    /**
     * @param QueryFilterManagerInterface $manager
     * @param string                      $name
     * @param array<mixed>                $options
     *
     * @return SortInterface
     */
    public function create(QueryFilterManagerInterface $manager, string $name, array $options = []): SortInterface
    {
        return $this->build(
            $name,
            $options
        );
    }
}
