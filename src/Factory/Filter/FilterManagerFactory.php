<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query\Factory\Filter;

use Arp\LaminasDoctrine\Query\Filter\FilterManager;
use Arp\LaminasFactory\AbstractFactory;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\InvalidArgumentException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query\Factory\Filter
 */
final class FilterManagerFactory extends AbstractFactory
{
    /**
     * @noinspection PhpMissingParamTypeInspection
     *
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return FilterManager
     *
     * @throws InvalidArgumentException
     * @throws ServiceNotFoundException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): FilterManager
    {
        $config = $this->getApplicationOptions($container, 'query_filter_manager');

        return new FilterManager($container, $config);
    }
}
