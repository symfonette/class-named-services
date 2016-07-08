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

use Symfonette\ClassNamedServices\Exception\AmbiguousServiceException;

class AmbiguousService
{
    public static function throwException($class, $services)
    {
        throw new AmbiguousServiceException($class, $services);
    }
}
