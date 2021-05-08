<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrineQueryFilter\Factory\Filter;

use Arp\DoctrineQueryFilter\Filter\FilterInterface;
use Arp\DoctrineQueryFilter\QueryFilterManager;
use Arp\LaminasFactory\AbstractFactory;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Psr\Container\ContainerInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrineQueryFilter\Factory\Filter
 */
final class QueryFilterFactory extends AbstractFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array<mixed>|null  $options
     *
     * @return FilterInterface
     *
     * @throws ServiceNotCreatedException
     * @throws ServiceNotFoundException
     */
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        array $options = null
    ): FilterInterface {
        $options = $options ?? $this->getServiceOptions($container, $requestedName, 'query_filters');

        $className = $options['class_name'] ?? $requestedName;

        $queryFilterManager = $options['query_filter_manager'] ?? null;
        if (null === $queryFilterManager) {
            $queryFilterManager = $this->getService($container, QueryFilterManager::class, $requestedName);
        }

        return new $className($queryFilterManager);
    }
}
