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

use Symfony\Component\DependencyInjection\Definition;

class AmbiguousDefinition extends Definition
{
    private $services;

    public function __construct($class, array $services)
    {
        parent::__construct($class, [$class, $services]);
        $this->setFactory([AmbiguousService::class, 'throwException']);
        $this->services = $services;
    }

    public function getServices()
    {
        return $this->services;
    }
}
