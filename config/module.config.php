<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query;

use Arp\DoctrineQueryFilter\Filter\AndX;
use Arp\DoctrineQueryFilter\Filter\InnerJoin;
use Arp\DoctrineQueryFilter\Filter\IsBetween;
use Arp\DoctrineQueryFilter\Filter\IsEqual;
use Arp\DoctrineQueryFilter\Filter\IsGreaterThan;
use Arp\DoctrineQueryFilter\Filter\IsGreaterThanOrEqual;
use Arp\DoctrineQueryFilter\Filter\IsIn;
use Arp\DoctrineQueryFilter\Filter\IsLessThan;
use Arp\DoctrineQueryFilter\Filter\IsLessThanOrEqual;
use Arp\DoctrineQueryFilter\Filter\IsLike;
use Arp\DoctrineQueryFilter\Filter\IsMemberOf;
use Arp\DoctrineQueryFilter\Filter\IsNotEqual;
use Arp\DoctrineQueryFilter\Filter\IsNotIn;
use Arp\DoctrineQueryFilter\Filter\IsNotLike;
use Arp\DoctrineQueryFilter\Filter\IsNotNull;
use Arp\DoctrineQueryFilter\Filter\IsNull;
use Arp\DoctrineQueryFilter\Filter\LeftJoin;
use Arp\DoctrineQueryFilter\Filter\OrX;
use Arp\DoctrineQueryFilter\Sort\SortFactory;
use Arp\LaminasDoctrineQueryFilter\Factory\Filter\FilterManagerFactory;
use Arp\LaminasDoctrineQueryFilter\Factory\Filter\QueryFilterFactory;
use Arp\LaminasDoctrineQueryFilter\Factory\Sort\SortFactoryFactory;
use Arp\LaminasDoctrineQueryFilter\Filter\FilterManager;

return [
    'arp' => [
        'query_filters' => [

        ],
    ],

    'service_manager' => [
        'aliases' => [
            'FilterFactory' => FilterManager::class,
        ],
        'factories' => [
            FilterManager::class => FilterManagerFactory::class,
            SortFactory::class => SortFactoryFactory::class,
        ],
    ],

    'query_filter_manager' => [
        'aliases'   => [
            'andx'       => AndX::class,
            'innerjoin'  => InnerJoin::class,
            'between'    => IsBetween::class,
            'eq'         => IsEqual::class,
            'gt'         => IsGreaterThan::class,
            'gte'        => IsGreaterThanOrEqual::class,
            'in'         => IsIn::class,
            'lt'         => IsLessThan::class,
            'lte'        => IsLessThanOrEqual::class,
            'like'       => IsLike::class,
            'memberof'   => IsMemberOf::class,
            'neq'        => IsNotEqual::class,
            'notin'      => IsNotIn::class,
            'notlike'    => IsNotLike::class,
            'notnull'    => IsNotNull::class,
            'null'       => IsNull::class,
            'leftjoin'   => LeftJoin::class,
            'orx'        => OrX::class,
        ],
        'factories' => [
            AndX::class                 => QueryFilterFactory::class,
            InnerJoin::class            => QueryFilterFactory::class,
            IsBetween::class            => QueryFilterFactory::class,
            IsEqual::class              => QueryFilterFactory::class,
            IsGreaterThan::class        => QueryFilterFactory::class,
            IsGreaterThanOrEqual::class => QueryFilterFactory::class,
            IsIn::class                 => QueryFilterFactory::class,
            IsLessThan::class           => QueryFilterFactory::class,
            IsLessThanOrEqual::class    => QueryFilterFactory::class,
            IsLike::class               => QueryFilterFactory::class,
            IsMemberOf::class           => QueryFilterFactory::class,
            IsNotEqual::class           => QueryFilterFactory::class,
            IsNotIn::class              => QueryFilterFactory::class,
            IsNotLike::class            => QueryFilterFactory::class,
            IsNotNull::class            => QueryFilterFactory::class,
            IsNull::class               => QueryFilterFactory::class,
            LeftJoin::class             => QueryFilterFactory::class,
            OrX::class                  => QueryFilterFactory::class,
        ],
    ],
];
