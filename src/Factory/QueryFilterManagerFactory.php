<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query\Factory;

use Arp\DoctrineQueryFilter\Filter\FilterManagerInterface;
use Arp\DoctrineQueryFilter\QueryFilterManager;
use Arp\LaminasDoctrine\Query\Filter\FilterManager;
use Arp\LaminasFactory\AbstractFactory;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query\Factory
 */
final class QueryFilterManagerFactory extends AbstractFactory
{
    /**
     * @noinspection PhpMissingParamTypeInspection
     *
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return QueryFilterManager
     *
     * @throws ServiceNotCreatedException
     * @throws ServiceNotFoundException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): QueryFilterManager
    {
        /** @var FilterManagerInterface $filterManager */
        $filterManager = $this->getService($container, FilterManager::class, $requestedName);

        return new QueryFilterManager($filterManager);
    }
}
