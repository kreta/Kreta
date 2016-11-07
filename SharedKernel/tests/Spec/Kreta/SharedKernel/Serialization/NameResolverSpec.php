<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spec\Kreta\SharedKernel\Serialization;

use Kreta\SharedKernel\Serialization\ClassNameDoesNotExistException;
use Kreta\SharedKernel\Serialization\NameResolver;
use Kreta\SharedKernel\Serialization\Resolver;
use Kreta\SharedKernel\Tests\Double\Serialization\NameResolverStub;
use PhpSpec\ObjectBehavior;

class NameResolverSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(NameResolverStub::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NameResolver::class);
        $this->shouldImplement(Resolver::class);
    }

    function it_resolves()
    {
        $this->resolve('Fully\Qualified\Class\Name')->shouldReturn('dummy_name');
    }

    function it_does_not_resolves_when_class_name_does_not_exist()
    {
        $this->shouldThrow(ClassNameDoesNotExistException::class)->duringResolve('Other\Fully\Qualified\Class\Name');
    }
}
