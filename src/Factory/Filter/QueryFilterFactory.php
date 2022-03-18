<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrineQueryFilter\Factory\Filter;

use Arp\DoctrineQueryFilter\Filter\FilterInterface;
use Arp\DoctrineQueryFilter\Filter\Typecaster;
use Arp\DoctrineQueryFilter\QueryFilterManager;
use Arp\LaminasFactory\AbstractFactory;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Psr\Container\ContainerExceptionInterface;
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
     * @throws ContainerExceptionInterface
     */
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        array $options = null
    ): FilterInterface {
        $options = $options ?? $this->getServiceOptions($container, $requestedName, 'query_filters');

        /** @var class-string<FilterInterface> $className */
        $className = $options['class_name'] ?? $requestedName;

        $queryFilterManager = $this->getService(
            $container,
            $options['query_filter_manager'] ?? QueryFilterManager::class,
            $requestedName
        );

        $typecaster = $this->getService(
            $container,
            $options['typecaster'] ?? Typecaster::class,
            $requestedName
        );

        return new $className($queryFilterManager, $typecaster, $options['options'] ?? []);
    }
}
