<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query\Filter;

use Arp\LaminasDoctrine\Query\Exception\InvalidArgumentException;
use Arp\LaminasDoctrine\Query\Metadata\MetadataInterface;
use Arp\LaminasDoctrine\Query\QueryFilterManager;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query\Filter
 */
abstract class AbstractFilter implements FilterInterface
{
    /**
     * @var QueryFilterManager
     */
    protected QueryFilterManager $queryFilterManager;

    /**
     * @param QueryFilterManager $queryFilterManager
     */
    public function __construct(QueryFilterManager $queryFilterManager)
    {
        $this->queryFilterManager = $queryFilterManager;
    }

    /**
     * @param array $criteria
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    protected function resolveFieldName(array $criteria): string
    {
        $field = $criteria['field'] ?? null;
        if (null === $field) {
            throw new InvalidArgumentException(
                sprintf('The required \'field\' criteria value is missing for filter \'%s\'', static::class)
            );
        }
        return $field;
    }

    /**
     * @param string $fieldName
     * @param array  $criteria
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    protected function resolveValue(string $fieldName, array $criteria)
    {
        if (!array_key_exists('value', $criteria)) {
            throw new InvalidArgumentException(
                sprintf(
                    'The required \'value\' criteria value is missing for filter \'%s::%s\'',
                    static::class,
                    $fieldName
                )
            );
        }
        return $criteria['value'];
    }

    /**
     * @param MetadataInterface $metadata
     * @param string            $fieldName
     * @param mixed             $value
     * @param string|null       $format
     *
     * @return mixed
     */
    protected function formatValue(MetadataInterface $metadata, string $fieldName, $value, ?string $format = null)
    {
        return $value;
    }
}
