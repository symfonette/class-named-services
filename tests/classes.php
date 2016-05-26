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

interface IA
{
}

interface IC
{
}

interface IB extends IC
{
}

class C implements IB
{
}

class B extends C
{
}

class A extends B implements IA
{
}

class E
{
}
