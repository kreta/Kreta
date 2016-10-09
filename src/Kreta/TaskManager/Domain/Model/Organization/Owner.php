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

namespace Kreta\TaskManager\Domain\Model\Organization;

use Kreta\SharedKernel\Domain\Model\Identity\EmailAddress;
use Kreta\SharedKernel\Domain\Model\Identity\Username;

class Owner extends Participant
{
    public function __construct(OwnerId $id, EmailAddress $email, Username $username)
    {
        parent::__construct($id, $email, $username);
    }
}
