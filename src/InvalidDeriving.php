<?php

declare(strict_types=1);

namespace Fpp;

class InvalidDeriving extends \RuntimeException
{
    public static function conflictingDerivings(
        Definition $definition,
        string $deriving1,
        string $deriving2
    ): InvalidDeriving {
        return new self(sprintf(
            'Invalid deriving on %s, deriving %s conflicts with deriving $s',
            self::className($definition),
            $deriving1,
            $deriving2
        ));
    }

    public static function exactlyOneConstructorExpected(Definition $definition, string $deriving): InvalidDeriving
    {
        return new self(sprintf(
            'Invalid deriving on $s, deriving %s expects exactly one constructor',
            self::className($definition),
            $deriving
        ));
    }

    public static function atLeastTwoConstructorsExpected(Definition $definition, string $deriving): InvalidDeriving
    {
        return new self(sprintf(
            'Invalid deriving on $s, deriving %s expects at least two constructors',
            self::className($definition),
            $deriving
        ));
    }

    public static function exactlyZeroConstructorArgumentsExpected(Definition $definition, string $deriving): InvalidDeriving
    {
        return new self(sprintf(
            'Invalid deriving on $s, deriving %s expects exactly zero constructor arguments',
            self::className($definition),
            $deriving
        ));
    }

    public static function exactlyOneConstructorArgumentExpected(Definition $definition, string $deriving): InvalidDeriving
    {
        return new self(sprintf(
            'Invalid deriving on $s, deriving %s expects exactly one constructor argument',
            self::className($definition),
            $deriving
        ));
    }

    public static function atLeastOneConstructorArgumentExpected(Definition $definition, string $deriving): InvalidDeriving
    {
        return new self(sprintf(
            'Invalid deriving on $s, deriving %s expects at least one constructor argument',
            self::className($definition),
            $deriving
        ));
    }

    public static function atLeastTwoConstructorArgumentsExpected(Definition $definition, string $deriving): InvalidDeriving
    {
        return new self(sprintf(
            'Invalid deriving on $s, deriving %s expects at least two constructor arguments',
            self::className($definition),
            $deriving
        ));
    }

    public static function noConditionsExpected(Definition $definition, string $deriving): InvalidDeriving
    {
        return new self(sprintf(
            'Invalid deriving on $s, deriving %s expects no conditions at all',
            self::className($definition),
            $deriving
        ));
    }

    private static function className(Definition $definition): string
    {
        if ($definition->namespace() !== '') {
            return $definition->namespace() . '\\' . $definition->name();
        }

        return$definition->name();
    }
}
