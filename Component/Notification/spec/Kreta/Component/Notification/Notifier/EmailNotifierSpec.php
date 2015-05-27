<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Notification\Notifier;

use Kreta\Component\Notification\Model\Interfaces\NotificationInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class EmailNotifierSpec.
 *
 * @package spec\Kreta\Component\Notification\Notifier
 */
class EmailNotifierSpec extends ObjectBehavior
{
    function let(\Swift_Mailer $mailer)
    {
        $this->beConstructedWith($mailer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\Notifier\EmailNotifier');
    }

    function it_implements_notifier_interface()
    {
        $this->shouldImplement('Kreta\Component\Notification\Notifier\Interfaces\NotifierInterface');
    }

    function it_notifies(
        \Swift_Mailer $mailer,
        \Swift_Mime_Message $message,
        NotificationInterface $notification,
        UserInterface $user
    )
    {
        $notification->getUser()->shouldBeCalled()->willReturn($user);
        $user->getEmail()->shouldBeCalled()->willReturn('kreta@kreta.io');
        $notification->getTitle()->shouldBeCalled()->willReturn('New issue!');
        $notification->getDescription()->shouldBeCalled()->willReturn('Notification body');

        $mailer->createMessage()->shouldBeCalled()->willReturn($message);
        $message->setTo('kreta@kreta.io')->shouldBeCalled()->willReturn($message);
        $message->setFrom('notifications@kreta.io')->shouldBeCalled()->willReturn($message);
        $message->setSubject('New issue!')->shouldBeCalled()->willReturn($message);
        $message->setBody('Notification body')->shouldBeCalled()->willReturn($message);

        $mailer->send($message)->shouldBeCalled();

        $this->notify($notification);
    }
}
