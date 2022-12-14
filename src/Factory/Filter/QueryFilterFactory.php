<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrineQueryFilter\Factory\Filter;

use Arp\DoctrineQueryFilter\Filter\FilterInterface;
use Arp\DoctrineQueryFilter\Metadata\ParamNameGeneratorInterface;
use Arp\DoctrineQueryFilter\Metadata\Typecaster;
use Arp\DoctrineQueryFilter\Metadata\TypecasterInterface;
use Arp\DoctrineQueryFilter\Metadata\UniqidParamNameGenerator;
use Arp\DoctrineQueryFilter\QueryFilterManager;
use Arp\DoctrineQueryFilter\QueryFilterManagerInterface;
use Arp\LaminasFactory\AbstractFactory;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

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

        /** @var QueryFilterManagerInterface $queryFilterManager */
        $queryFilterManager = $this->getService(
            $container,
            $options['query_filter_manager'] ?? QueryFilterManager::class,
            $requestedName
        );

        /** @var TypecasterInterface $typecaster */
        $typecaster = $this->getService(
            $container,
            $options['typecaster'] ?? Typecaster::class,
            $requestedName
        );

        /** @var ParamNameGeneratorInterface $paramNameGenerator */
        $paramNameGenerator = $this->getService(
            $container,
            $options['param_name_generator'] ?? UniqidParamNameGenerator::class,
            $requestedName
        );

        return new $className($queryFilterManager, $typecaster, $paramNameGenerator);
    }
}
