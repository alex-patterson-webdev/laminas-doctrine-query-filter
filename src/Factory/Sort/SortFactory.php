<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrineQueryFilter\Factory\Sort;

use Arp\DoctrineQueryFilter\Sort\SortInterface;
use Arp\LaminasFactory\AbstractFactory;
use Psr\Container\ContainerInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrineQueryFilter\Factory\Sort
 */
final class SortFactory extends AbstractFactory
{
    /**
     * @param ContainerInterface          $container
     * @param class-string<SortInterface> $requestedName
     * @param array<mixed>|null           $options
     *
     * @return SortInterface
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null): SortInterface
    {
        return new $requestedName();
    }
}
