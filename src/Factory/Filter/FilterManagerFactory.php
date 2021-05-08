<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrineQueryFilter\Factory\Filter;

use Arp\LaminasDoctrineQueryFilter\Filter\FilterManager;
use Arp\LaminasFactory\AbstractFactory;
use Laminas\ServiceManager\Exception\InvalidArgumentException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Psr\Container\ContainerInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrineQueryFilter\Factory\Filter
 */
final class FilterManagerFactory extends AbstractFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array<mixed>|null  $options
     *
     * @return FilterManager
     *
     * @throws InvalidArgumentException
     * @throws ServiceNotFoundException
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null): FilterManager
    {
        $config = $this->getApplicationOptions($container, 'query_filter_manager');

        return new FilterManager($container, $config);
    }
}
