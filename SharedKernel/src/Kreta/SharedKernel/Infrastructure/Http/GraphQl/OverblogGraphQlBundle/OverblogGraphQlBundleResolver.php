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

declare(strict_types=1);

namespace Kreta\SharedKernel\Infrastructure\Http\GraphQl\OverblogGraphQlBundle;

use Kreta\SharedKernel\Http\GraphQl\Resolver;
use Overblog\GraphQLBundle\Resolver\ResolverInterface;

class OverblogGraphQlBundleResolver implements Resolver
{
    private $resolver;

    public function __construct(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    public function resolve($args)
    {
        return $this->resolver->resolve($args);
    }
}
