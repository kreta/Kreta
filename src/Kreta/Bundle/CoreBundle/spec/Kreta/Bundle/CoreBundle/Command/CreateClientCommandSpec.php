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

namespace spec\Kreta\Bundle\CoreBundle\Command;

use FOS\OAuthServerBundle\Entity\ClientManager;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use Kreta\Bundle\CoreBundle\Model\Interfaces\ClientInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CreateClientCommandSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\Command
 */
class CreateClientCommandSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Command\CreateClientCommand');
    }

    function it_extends_container_aware_command()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand');
    }

    function it_executes(
        ContainerInterface $container,
        ClientManager $clientManager,
        ClientInterface $client,
        InputInterface $input,
        OutputInterface $output
    )
    {
        $container->get('fos_oauth_server.client_manager.default')->shouldBeCalled()->willReturn($clientManager);
        $clientManager->createClient()->shouldBeCalled()->willReturn($client);

        $input->hasArgument('command')->shouldBeCalled()->willReturn(true);
        $input->getArgument('command')->shouldBeCalled()->willReturn('command');
        $input->bind(Argument::any())->shouldBeCalled();
        $input->isInteractive()->shouldBeCalled()->willReturn(false);
        $input->validate()->shouldBeCalled();

        $input->getOption('redirect-uri')
            ->shouldBeCalled()->willReturn(['the-redirect-uri']);
        $client->setRedirectUris(['the-redirect-uri'])->shouldBeCalled();

        $input->getOption('grant-type')
            ->shouldBeCalled()->willReturn(['the-grant-type']);
        $client->setAllowedGrantTypes(['the-grant-type'])->shouldBeCalled();

        $clientManager->updateClient($client)->shouldBeCalled();

        $client->getPublicId()->shouldBeCalled()->willReturn('public-id');
        $client->getSecret()->shouldBeCalled()->willReturn('secret');

        $output->writeln(
            sprintf(
                'A new client with public id <info>%s</info>, secret <info>%s</info> has been added',
                'public-id',
                'secret'
            )
        )->shouldBeCalled();

        $this->run($input, $output);
    }

    function it_generates_client(
        ContainerInterface $container,
        ClientManagerInterface $clientManager,
        ClientInterface $client
    )
    {
        $container->get('fos_oauth_server.client_manager.default')->shouldBeCalled()->willReturn($clientManager);
        $clientManager->createClient()->shouldBeCalled()->willReturn($client);
        $client->setRedirectUris(['http://kreta.io'])->shouldBeCalled();
        $client->setAllowedGrantTypes(
            ['authorization_code', 'password', 'refresh_token', 'token', 'client_credentials']
        )->shouldBeCalled();
        $client->setSecret('dummy-client-secret')->shouldBeCalled();
        $clientManager->updateClient($client)->shouldBeCalled();

        $this->generateClient(
            ['http://kreta.io'],
            ['authorization_code', 'password', 'refresh_token', 'token', 'client_credentials'],
            'dummy-client-secret'
        )->shouldReturn($client);
    }
}
