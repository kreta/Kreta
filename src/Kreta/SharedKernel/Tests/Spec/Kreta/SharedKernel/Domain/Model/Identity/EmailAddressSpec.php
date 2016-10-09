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

namespace Spec\Kreta\SharedKernel\Domain\Model\Identity;

use Kreta\SharedKernel\Domain\Model\Identity\EmailAddress;
use Kreta\SharedKernel\Domain\Model\Identity\EmailAddressInvalidException;
use PhpSpec\ObjectBehavior;

class EmailAddressSpec extends ObjectBehavior
{
    function it_constructs_with_valid_email_address()
    {
        $this->beConstructedWith('bengor@user.com');
        $this->shouldHaveType(EmailAddress::class);

        $this->email()->shouldBe('bengor@user.com');
        $this->domain()->shouldBe('user.com');
        $this->localPart()->shouldBe('bengor');
        $this->__toString()->shouldBe('bengor@user.com');
    }

    function it_constructs_with_invalid_email_address()
    {
        $this->beConstructedWith('invalid string');

        $this->shouldThrow(EmailAddressInvalidException::class)->duringInstantiation();
    }

    function it_compares_email_addresses()
    {
        $this->beConstructedWith('bengor@user.com');

        $this->equals(new EmailAddress('bengor@user.com'))->shouldBe(true);
    }

    function it_compares_different_email_addresses()
    {
        $this->beConstructedWith('bengor@user.com');

        $this->equals(new EmailAddress('not-bengor@user.com'))->shouldBe(false);
    }
}
