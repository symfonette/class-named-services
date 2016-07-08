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

use Symfonette\ClassNamedServices\ContainerBuilderConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CheckAmbiguousReferencePassTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContainerBuilder */
    private $container;

    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        (new ContainerBuilderConfigurator())->configure($this->container);
    }

    /**
     * @expectedException Symfonette\ClassNamedServices\Exception\AmbiguousReferenceException
     * @expectedExceptionMessage Ambiguous services for class "Symfonette\ClassNamedServices\Tests\E". You should use concrete service name instead of class: "foo", "bar"
     */
    public function testThrowExceptionForAmbiguousDefinitionInArguments()
    {
        $container = $this->container;
        $container->register('foo', E::class);
        $container->register('bar', E::class);

        $definition = $container->register('baz', A::class);
        $definition->setArguments([new Reference(E::class)]);

        $container->compile();
    }
}
