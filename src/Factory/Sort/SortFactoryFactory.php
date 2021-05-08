<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrineQueryFilter\Factory\Sort;

use Arp\DoctrineQueryFilter\Sort\SortFactory;
use Arp\DoctrineQueryFilter\Sort\SortFactoryInterface;
use Arp\LaminasFactory\AbstractFactory;
use Psr\Container\ContainerInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrineQueryFilter\Factory\Sort
 */
final class SortFactoryFactory extends AbstractFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array<mixed>|null  $options
     *
     * @return SortFactoryInterface
     */
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        array $options = null
    ): SortFactoryInterface {
        $options = $options ?? $this->getServiceOptions($container, $requestedName);

        return new SortFactory($options['class_map'] ?? [], $options['options'] ?? []);
    }
}
