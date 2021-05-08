<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrineQueryFilter\Factory;

use Arp\DoctrineQueryFilter\Filter\FilterFactoryInterface;
use Arp\DoctrineQueryFilter\QueryFilterManager;
use Arp\DoctrineQueryFilter\Sort\SortFactory;
use Arp\DoctrineQueryFilter\Sort\SortFactoryInterface;
use Arp\LaminasDoctrineQueryFilter\Filter\FilterManager;
use Arp\LaminasFactory\AbstractFactory;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Psr\Container\ContainerInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query\Factory
 */
final class QueryFilterManagerFactory extends AbstractFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array<mixed>|null  $options
     *
     * @return QueryFilterManager
     *
     * @throws ServiceNotCreatedException
     * @throws ServiceNotFoundException
     */
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        array $options = null
    ): QueryFilterManager {
        /** @var FilterFactoryInterface $filterFactory */
        $filterFactory = $this->getService($container, FilterManager::class, $requestedName);

        /** @var SortFactoryInterface $sortFactory */
        $sortFactory = $this->getService($container, SortFactory::class, $requestedName);

        return new QueryFilterManager($filterFactory, $sortFactory);
    }
}
