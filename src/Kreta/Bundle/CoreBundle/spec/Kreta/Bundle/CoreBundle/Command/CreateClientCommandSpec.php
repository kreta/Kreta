<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CoreBundle\Command;

use FOS\OAuthServerBundle\Entity\ClientManager;
use FOS\OAuthServerBundle\Model\ClientInterface;
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
}
