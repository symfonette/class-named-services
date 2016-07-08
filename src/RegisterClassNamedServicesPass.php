<?php

/*
 * This is part of the symfonette/class-named-services package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 * (c) Webuni s.r.o. <info@webuni.cz>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfonette\ClassNamedServices;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class RegisterClassNamedServicesPass implements CompilerPassInterface
{
    private $container;
    private $types;
    private $definedTypes;
    private $reflectionClasses = [];

    public function process(ContainerBuilder $container)
    {
        $throwingAutoloader = function ($class) { throw new \ReflectionException(sprintf('Class %s does not exist', $class)); };
        spl_autoload_register($throwingAutoloader);

        try {
            $this->container = $container;
            foreach ($container->getDefinitions() as $id => $definition) {
                $this->populateAvailableTypes($id, $definition);
            }

            $this->populateAvailableTypes('service_container', new Definition(get_class($container)));

            foreach ($this->types as $type => $services) {
                $this->registerService($type, $services);
            }
        } catch (\Exception $e) {
        } catch (\Throwable $e) {
        }

        spl_autoload_unregister($throwingAutoloader);

        // Free memory and remove circular reference to container
        $this->container = null;
        $this->reflectionClasses = [];
        $this->definedTypes = [];
        $this->types = null;

        if (isset($e)) {
            throw $e;
        }
    }

    private function populateAvailableTypes($id, Definition $definition)
    {
        if ($definition->isAbstract()) {
            return;
        }

        foreach ($definition->getAutowiringTypes() as $type) {
            $this->definedTypes[$type] = true;
            $this->types[$type][] = $id;
        }

        if (!$reflectionClass = $this->getReflectionClass($id, $definition)) {
            return;
        }

        foreach ($reflectionClass->getInterfaces() as $reflectionInterface) {
            $this->set($reflectionInterface->name, $id);
        }

        do {
            $this->set($reflectionClass->name, $id);
        } while ($reflectionClass = $reflectionClass->getParentClass());
    }

    private function getReflectionClass($id, Definition $definition)
    {
        if (isset($this->reflectionClasses[$id])) {
            return $this->reflectionClasses[$id];
        }

        if (!$class = $definition->getClass()) {
            return false;
        }

        $class = $this->container->getParameterBag()->resolveValue($class);

        try {
            $reflector = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            $reflector = false;
        }

        return $this->reflectionClasses[$id] = $reflector;
    }

    private function set($type, $id)
    {
        if (isset($this->definedTypes[$type])) {
            return;
        }

        $this->types[$type][] = $id;
    }

    private function registerService($type, array $services)
    {
        if (1 === count($services)) {
            $service = reset($services);
            $isPublic = 'service_container' === $service ? true : $this->container->getDefinition($service)->isPublic();
            $this->container->setAlias($type, new Alias($service, $isPublic));
        } else {
            $this->container->setDefinition($type, new AmbiguousDefinition($type, $services));
        }
    }
}
