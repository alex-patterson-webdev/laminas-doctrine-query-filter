<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query\Factory\Filter;

use Arp\LaminasDoctrine\Query\Filter\FilterInterface;
use Arp\LaminasDoctrine\Query\QueryFilterManager;
use Arp\LaminasFactory\AbstractFactory;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query\Factory\Filter
 */
final class QueryFilterFactory extends AbstractFactory
{
    /**
     * @noinspection PhpMissingParamTypeInspection
     *
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return FilterInterface
     *
     * @throws ServiceNotCreatedException
     * @throws ServiceNotFoundException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): FilterInterface
    {
        $options = $options ?? $this->getServiceOptions($container, $requestedName, 'query_filters');

        $className = $options['class_name'] ?? $requestedName;

        $queryFilterManager = $options['query_filter_manager'] ?? null;
        if (null === $queryFilterManager) {
            $queryFilterManager = $this->getService($container, QueryFilterManager::class, $requestedName);
        }

        return new $className($queryFilterManager);
    }
}
