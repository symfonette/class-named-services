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

use Symfonette\ClassNamedServices\CheckAmbiguousReferencesPass;
use Symfonette\ClassNamedServices\ContainerBuilderConfigurator;
use Symfonette\ClassNamedServices\RegisterClassNamedServicesPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\Compiler\ResolveReferencesToAliasesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ContainerBuilderConfiguratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var PassConfig */
    private $passConfig;

    protected function setUp()
    {
        $configurator = new ContainerBuilderConfigurator();
        $builder = new ContainerBuilder();

        $configurator->configure($builder);

        $this->passConfig = $builder->getCompilerPassConfig();
    }

    public function testAddRegisterClassNamedServicePass()
    {
        $classes = array_map('get_class', $this->passConfig->getOptimizationPasses());

        $this->assertEquals(
            [RegisterClassNamedServicesPass::class, ResolveReferencesToAliasesPass::class],
            array_slice($classes, 5, 2)
        );
    }

    public function testAddCheckAmbiguousReferencesPass()
    {
        $classes = array_map('get_class', $this->passConfig->getAfterRemovingPasses());

        $this->assertContains(CheckAmbiguousReferencesPass::class, $classes);
    }
}
