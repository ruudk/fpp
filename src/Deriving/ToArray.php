<?php

declare(strict_types=1);

namespace Fpp\Deriving;

use Fpp\Definition;
use Fpp\Deriving as FppDeriving;
use Fpp\InvalidDeriving;

class ToArray implements FppDeriving
{
    const VALUE = 'ToArray';

    public function checkDefinition(Definition $definition): void
    {
        foreach ($definition->derivings() as $deriving) {
            if (in_array((string) $deriving, $this->forbidsDerivings(), true)) {
                throw InvalidDeriving::conflictingDerivings($definition, self::VALUE, (string) $deriving);
            }
        }

        foreach ($definition->constructors() as $constructor) {
            if (count($constructor->arguments()) < 2) {
                throw InvalidDeriving::atLeastTwoConstructorArgumentsExpected($definition, self::VALUE);
            }
        }
    }

    public function __toString(): string
    {
        return self::VALUE;
    }

    private function forbidsDerivings(): array
    {
        return [
            AggregateChanged::VALUE,
            Command::VALUE,
            DomainEvent::VALUE,
            Enum::VALUE,
            Query::VALUE,
            Uuid::VALUE,
        ];
    }
}
