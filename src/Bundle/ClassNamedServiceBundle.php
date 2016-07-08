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

namespace Symfonette\ClassNamedServices\Bundle;

use Symfonette\ClassNamedServices\ContainerBuilderConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ClassNamedServiceBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $configurator = new ContainerBuilderConfigurator();
        $configurator->configure($container);
    }
}
