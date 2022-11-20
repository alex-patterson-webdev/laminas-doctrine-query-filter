<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrineQueryFilter\Factory\Sort;

use Arp\LaminasDoctrineQueryFilter\Sort\SortManager;
use Arp\LaminasFactory\AbstractFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

final class SortManagerFactory extends AbstractFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array<mixed>|null  $options
     *
     * @return SortManager
     *
     * @throws ContainerExceptionInterface
     */
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        array $options = null
    ): SortManager {
        $config = $this->getApplicationOptions($container, 'sort_filter_manager');

        return new SortManager($container, $config);
    }
}
