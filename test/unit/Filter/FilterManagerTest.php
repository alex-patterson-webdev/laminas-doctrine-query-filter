<?php

declare(strict_types=1);

namespace ArpTest\LaminasDoctrine\Query\Filter;

use Arp\DoctrineQueryFilter\Filter\FilterManagerInterface;
use Arp\LaminasDoctrine\Query\Filter\FilterManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers  \Arp\LaminasDoctrine\Query\Filter\FilterManager
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\LaminasDoctrine\Query\Filter
 */
final class FilterManagerTest extends TestCase
{
    /**
     * @var ContainerInterface|MockObject
     */
    private $container;

    /**
     * Prepare the test case dependencies
     */
    public function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
    }

    /**
     * Assert that the FilterManager implements the FilterManagerInterface
     */
    public function testInstanceOfFilterManagerInterface(): void
    {
        $manager = new FilterManager($this->container);

        $this->assertInstanceOf(FilterManagerInterface::class, $manager);
    }
}
