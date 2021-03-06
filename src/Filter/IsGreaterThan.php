<?php

declare(strict_types=1);

namespace Arp\LaminasDoctrine\Query\Filter;

use Doctrine\ORM\Query\Expr;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasDoctrine\Query\Filter
 */
final class IsGreaterThan extends AbstractExpression
{
    /**
     * @param Expr   $expr
     * @param string $fieldName
     * @param string $parameterName
     * @param string $alias
     *
     * @return string
     */
    protected function createExpression(Expr $expr, string $fieldName, string $parameterName, string $alias): string
    {
        return (string)$expr->gt($alias . '.' . $fieldName, ':' . $parameterName);
    }
}
