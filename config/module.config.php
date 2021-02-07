<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query;

use Arp\DoctrineQueryFilter\Filter\AndX;
use Arp\DoctrineQueryFilter\Filter\InnerJoin;
use Arp\DoctrineQueryFilter\Filter\IsEqual;
use Arp\DoctrineQueryFilter\Filter\IsGreaterThan;
use Arp\DoctrineQueryFilter\Filter\IsGreaterThanOrEqual;
use Arp\DoctrineQueryFilter\Filter\IsLessThan;
use Arp\DoctrineQueryFilter\Filter\IsLessThanOrEqual;
use Arp\DoctrineQueryFilter\Filter\IsMemberOf;
use Arp\DoctrineQueryFilter\Filter\IsNotEqual;
use Arp\DoctrineQueryFilter\Filter\LeftJoin;
use Arp\DoctrineQueryFilter\Filter\OrX;
use Arp\LaminasDoctrine\Query\Factory\Filter\FilterManagerFactory;
use Arp\LaminasDoctrine\Query\Factory\Filter\QueryFilterFactory;
use Arp\LaminasDoctrine\Query\Filter\FilterManager;

return [
    'arp' => [
        'query_filters' => [

        ],
    ],

    'service_manager' => [
        'factories' => [
            FilterManager::class => FilterManagerFactory::class,
        ],
    ],

    'query_filter_manager' => [
        'aliases'   => [
            'eq'         => IsEqual::class,
            'neq'        => IsNotEqual::class,
            'gt'         => IsGreaterThan::class,
            'gte'        => IsGreaterThanOrEqual::class,
            'lt'         => IsLessThan::class,
            'lte'        => IsLessThanOrEqual::class,
            'innerjoin'  => InnerJoin::class,
            'leftjoin'   => LeftJoin::class,
            'andx'       => AndX::class,
            'orx'        => OrX::class,
            'ismemberof' => IsMemberOf::class,
        ],
        'factories' => [
            IsEqual::class              => QueryFilterFactory::class,
            IsNotEqual::class           => QueryFilterFactory::class,
            IsGreaterThan::class        => QueryFilterFactory::class,
            IsGreaterThanOrEqual::class => QueryFilterFactory::class,
            IsLessThan::class           => QueryFilterFactory::class,
            IsLessThanOrEqual::class    => QueryFilterFactory::class,
            InnerJoin::class            => QueryFilterFactory::class,
            LeftJoin::class             => QueryFilterFactory::class,
            AndX::class                 => QueryFilterFactory::class,
            OrX::class                  => QueryFilterFactory::class,
            IsMemberOf::class           => QueryFilterFactory::class,
        ],
    ],
];
