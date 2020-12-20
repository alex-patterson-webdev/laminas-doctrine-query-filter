<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query;

use Arp\LaminasDoctrine\Query\Factory\Filter\FilterManagerFactory;
use Arp\LaminasDoctrine\Query\Factory\Filter\QueryFilterFactory;
use Arp\LaminasDoctrine\Query\Factory\QueryFilterManagerFactory;
use Arp\LaminasDoctrine\Query\Filter\AndX;
use Arp\LaminasDoctrine\Query\Filter\FilterManager;
use Arp\LaminasDoctrine\Query\Filter\InnerJoin;
use Arp\LaminasDoctrine\Query\Filter\IsEqual;
use Arp\LaminasDoctrine\Query\Filter\IsGreaterThan;
use Arp\LaminasDoctrine\Query\Filter\IsGreaterThanOrEqual;
use Arp\LaminasDoctrine\Query\Filter\IsLessThan;
use Arp\LaminasDoctrine\Query\Filter\IsLessThanOrEqual;
use Arp\LaminasDoctrine\Query\Filter\IsMemberOf;
use Arp\LaminasDoctrine\Query\Filter\IsNotEqual;
use Arp\LaminasDoctrine\Query\Filter\LeftJoin;
use Arp\LaminasDoctrine\Query\Filter\OrX;

return [
    'arp' => [
        'query_filters' => [

        ],
    ],

    'service_manager' => [
        'factories' => [
            QueryFilterManager::class => QueryFilterManagerFactory::class,
            FilterManager::class      => FilterManagerFactory::class,
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
