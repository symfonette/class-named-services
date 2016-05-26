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

namespace Symfonette\DependencyInjection\ClassNamedServices\Exception;

use Symfony\Component\DependencyInjection\Exception\RuntimeException;

class AmbiguousServiceException extends RuntimeException implements ExceptionInterface
{
    public function __construct($type, $services)
    {
        parent::__construct(sprintf('Ambiguous services for class "%s". You should use concrete service name instead of class: "%s"', $type, implode('", "', $services)));
    }
}
