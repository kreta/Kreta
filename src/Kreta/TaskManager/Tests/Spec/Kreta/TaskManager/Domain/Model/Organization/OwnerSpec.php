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

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\TaskManager\Domain\Model\Organization\OwnerEmail;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;
use Kreta\TaskManager\Domain\Model\Organization\OwnerUsername;
use PhpSpec\ObjectBehavior;

class OwnerSpec extends ObjectBehavior
{
    function let(OwnerId $id, OwnerEmail $email, OwnerUsername $username)
    {
        $this->beConstructedWith($id, $email, $username);
    }
}
