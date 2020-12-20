<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query\Filter;

use Laminas\ServiceManager\AbstractPluginManager;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query
 */
class FilterManager extends AbstractPluginManager
{
    /**
     * @var string
     */
    protected $instanceOf = FilterInterface::class;
}
