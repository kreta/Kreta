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

namespace spec\Kreta\Bundle\UserBundle\Command;

use FOS\UserBundle\Doctrine\UserManager;
use Kreta\Component\User\Factory\UserFactory;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CreateUserCommandSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class CreateUserCommandSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\Command\CreateUserCommand');
    }

    function it_extends_container_aware_command()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand');
    }

    function it_executes(
        ContainerInterface $container,
        UserFactory $userFactory,
        UserInterface $user,
        UserManager $userManager,
        InputInterface $input,
        OutputInterface $output
    ) {
        $container->get('kreta_user.factory.user')->shouldBeCalled()->willReturn($userFactory);

        $input->bind(Argument::any())->shouldBeCalled();
        $input->isInteractive()->shouldBeCalled()->willReturn(true);
        $input->validate()->shouldBeCalled();

        $input->hasArgument('command')->shouldBeCalled()->willReturn(true);
        $input->getArgument('command')->shouldBeCalled()->willReturn('command');
        $input->getArgument('email')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $input->getArgument('username')->shouldBeCalled()->willReturn('kreta');
        $input->getArgument('firstName')->shouldBeCalled()->willReturn('Kreta');
        $input->getArgument('lastName')->shouldBeCalled()->willReturn('User');
        $input->getArgument('password')->shouldBeCalled()->willReturn('123456');

        $userFactory->create(
            'kreta@kreta.com', 'kreta', 'Kreta', 'User', true
        )->shouldBeCalled()->willReturn($user);
        $user->setPlainPassword('123456')->shouldBeCalled()->willReturn($user);

        $container->get('fos_user.user_manager')->shouldBeCalled()->willReturn($userManager);
        $userManager->updatePassword($user)->shouldBeCalled();
        $userManager->updateUser($user)->shouldBeCalled()->willReturn($user);

        $user->getUsername()->shouldBeCalled()->willReturn('kreta');
        $output->writeln(sprintf('A new <info>%s</info> user has been created', 'kreta'))->shouldBeCalled();

        $this->run($input, $output);
    }
}
