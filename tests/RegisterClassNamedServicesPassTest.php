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

namespace Symfonette\DependencyInjection\ClassNamedServices\Tests;

use Symfonette\DependencyInjection\ClassNamedServices\AmbiguousDefinition;
use Symfonette\DependencyInjection\ClassNamedServices\ContainerBuilderConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class RegisterClassNamedServicesPassTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContainerBuilder */
    private $container;

    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        (new ContainerBuilderConfigurator())->configure($this->container);
    }

    public function testRegisterFqcnServices()
    {
        $container = $this->container;
        $container->register('foo', A::class);
        $container->compile();

        $services = $container->getServiceIds();
        $this->assertArraySubset(array_map('strtolower', [
            'foo',
            IB::class,
            IC::class,
            IA::class,
            A::class,
            B::class,
            C::class,
        ]), $services);

        $this->assertContains(strtolower(ContainerInterface::class), $services);
        $this->assertContains('service_container', $services);
    }

    public function testRegisterFqcnServicesAsAliases()
    {
        $container = $this->container;
        $container->register('foo', A::class);
        $container->compile();

        $this->assertTrue($container->hasAlias(A::class));
        $this->assertTrue($container->hasAlias(IC::class));
        $this->assertEquals($container->findDefinition(B::class), $container->findDefinition(IC::class));
    }

    public function testNotRegisterForPrivateServices()
    {
        $container = $this->container;
        $definition = $container->register('bar', E::class);
        $definition->setPublic(false);

        $definition = $container->register('foo', A::class);
        $definition->setArguments([new Reference(E::class)]);
        $container->compile();

        $this->assertFalse($container->hasAlias(E::class));
        $this->assertInstanceOf(Definition::class, $container->getDefinition('foo')->getArgument(0));
    }

    public function testRegisterAmbiguousDefinition()
    {
        $container = $this->container;
        $container->register('foo', E::class);
        $container->register('bar', E::class);

        $container->compile();

        $this->assertInstanceOf(AmbiguousDefinition::class, $container->getDefinition(E::class));
    }
}
