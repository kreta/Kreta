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

namespace Kreta\IdentityAccess\Infrastructure\Serialization;

use BenGorUser\User\Domain\Model\Event\UserEnabled;
use Kreta\SharedKernel\Serialization\NameResolver as BaseNameResolver;

class NameResolver extends BaseNameResolver
{
    protected function map() : array
    {
        return [
            UserEnabled::class => 'kreta_identity_access.user_registered',
        ];
    }
}
