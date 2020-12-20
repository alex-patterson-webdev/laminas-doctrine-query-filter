<?php

declare(strict_types=1);

namespace ArpTest\LaminasDoctrine\Query;

use Arp\LaminasDoctrine\Query\Exception\QueryFilterManagerException;
use Arp\LaminasDoctrine\Query\Filter\FilterManager;
use Arp\LaminasDoctrine\Query\QueryBuilderInterface;
use Arp\LaminasDoctrine\Query\QueryFilterManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\LaminasDoctrine\Query
 */
final class QueryFilterManagerTest extends TestCase
{
    /**
     * @var FilterManager|MockObject
     */
    private $filterManager;

    /**
     * Prepare the test case dependencies
     */
    public function setUp(): void
    {
        $this->filterManager = $this->createMock(FilterManager::class);
    }

    /**
     * Assert no filtering will be applied if filter() is provided configuration without the required 'filters' key
     *
     * @throws QueryFilterManagerException
     */
    public function testFilterWillNotPerformFilteringWithoutFilterKey(): void
    {
        $queryFilterManager = new QueryFilterManager($this->filterManager);

        /** @var QueryBuilderInterface|MockObject $queryBuilder */
        $queryBuilder = $this->createMock(QueryBuilderInterface::class);

        $queryBuilder->expects($this->never())->method('getEntityManager');

        $queryFilterManager->filter($queryBuilder, 'Foo', []);
    }
}
