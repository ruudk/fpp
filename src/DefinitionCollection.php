<?php

declare(strict_types=1);

namespace Fpp;

class DefinitionCollection
{
    /**
     * @var array
     */
    private $registry = [];

    /**
     * @var Definition[]
     */
    private $definitions = [];

    /**
     * @var Definition[]
     */
    private $constructorDefinitions = [];

    public function __construct(Definition ...$definitions)
    {
        foreach ($definitions as $definition) {
            $this->addDefinition($definition);
        }
    }

    public function addDefinition(Definition $definition)
    {
        if (isset($this->registry[$definition->namespace()][$definition->name()])) {
            throw new \InvalidArgumentException(sprintf(
                'Duplicate definition found: %s\\%s',
                $definition->namespace(),
                $definition->name()
            ));
        }

        $this->registry[$definition->namespace()][$definition->name()] = true;

        $this->definitions[] = $definition;

        foreach ($definition->constructors() as $key => $constructor) {
            $this->constructorDefinitions[$constructor->name()] = $definition;
        }
    }

    public function hasDefinition(string $namespace, string $name): bool
    {
        return isset($this->registry[$namespace][$name]);
    }

    public function hasConstructorDefinition(string $name): bool
    {
        return isset($this->constructorDefinitions[$name]);
    }

    public function definition(string $namespace, string $name): ?Definition
    {
        foreach ($this->definitions as $definition) {
            if ($definition->namespace() === $namespace && $definition->name() === $name) {
                return $definition;
            }
        }

        return null;
    }

    public function constructorDefinition(string $name): ?Definition
    {
        return isset($this->constructorDefinitions[$name]) ? $this->constructorDefinitions[$name] : null;
    }

    public function merge(DefinitionCollection $collection): DefinitionCollection
    {
        $registry = $this->registry;
        $definitions = $this->definitions;

        foreach ($collection->definitions() as $definition) {
            if ($this->hasDefinition($definition->namespace(), $definition->name())) {
                throw new \InvalidArgumentException(sprintf(
                    'Duplicate definition found: %s\\%s',
                    $definition->namespace(),
                    $definition->name()
                ));
            }

            $registry[$definition->namespace()][$definition->name()] = true;
            $definitions[] = $definition;
        }

        $collection = new DefinitionCollection();
        $collection->registry = $registry;
        $collection->definitions = $definitions;

        return $collection;
    }

    /**
     * @return Definition[]
     */
    public function definitions(): array
    {
        return $this->definitions;
    }
}
