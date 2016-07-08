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

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\Compiler\ResolveReferencesToAliasesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ContainerBuilderConfigurator
{
    public function configure(ContainerBuilder $builder)
    {
        $this->addRegisterClassNamedServicesPass($builder);
        $this->addCheckAmbiguousReferencesPass($builder);
    }

    private function addRegisterClassNamedServicesPass(ContainerBuilder $builder)
    {
        $compilerPass = new RegisterClassNamedServicesPass();

        $passConfig = $builder->getCompilerPassConfig();
        $passes = $passConfig->getOptimizationPasses();
        foreach ($passes as $key => $pass) {
            if ($pass instanceof ResolveReferencesToAliasesPass) {
                array_splice($passes, $key, 0, [$compilerPass]);
                break;
            }
        }

        $passConfig->setOptimizationPasses($passes);

        $builder->addObjectResource($compilerPass);
    }

    private function addCheckAmbiguousReferencesPass(ContainerBuilder $builder)
    {
        $builder->addCompilerPass(new CheckAmbiguousReferencesPass(), PassConfig::TYPE_AFTER_REMOVING);
    }
}
