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

namespace Symfonette\ClassNamedServices\Tests;

use Symfonette\ClassNamedServices\AmbiguousDefinition;
use Symfonette\ClassNamedServices\ContainerBuilderConfigurator;
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

        $this->assertTrue($container->has('foo'));
        $this->assertTrue($container->has('service_container'));
        $this->assertTrue($container->has(IB::class));
        $this->assertTrue($container->has(IC::class));
        $this->assertTrue($container->has(IA::class));
        $this->assertTrue($container->has(A::class));
        $this->assertTrue($container->has(B::class));
        $this->assertTrue($container->has(C::class));
        $this->assertTrue($container->has(ContainerInterface::class));
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

    public function testRegisterEqualsServiceAndClassNames()
    {
        $container = $this->container;
        $container->register('symfonette_classnamedservices_tests_a', 'Symfonette_ClassNamedServices_Tests_A');

        $container->compile();
    }
}
