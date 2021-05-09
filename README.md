![build](https://github.com/alex-patterson-webdev/laminas-doctrine-query-filter/actions/workflows/workflow.yml/badge.svg)
[![codecov](https://codecov.io/gh/alex-patterson-webdev/laminas-doctrine-query-filter/branch/master/graph/badge.svg)](https://codecov.io/gh/alex-patterson-webdev/laminas-doctrine-query-filter)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-patterson-webdev/laminas-doctrine-query-filter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-patterson-webdev/laminas-doctrine-query-filter/?branch=master)

# Laminas Doctrine Query Filter

## About

A [Doctrine Query Filter](https://github.com/alex-patterson-webdev/doctrine-query-filter) integration module for Laminas Applications.

## Installation

Installation via [composer](https://getcomposer.org).

    require alex-patterson-webdev/laminas-doctrine-query-filter ^0.2

Add the module namespace to your module bootstrap configuration in `module.config.php`. Ensure that is listed after the relevant Doctrine modules.

    return [
        //...
        'DoctrineOrm',
        'Arp\\LaminasDoctrineQueryFilter\\Module',
    ];

    
