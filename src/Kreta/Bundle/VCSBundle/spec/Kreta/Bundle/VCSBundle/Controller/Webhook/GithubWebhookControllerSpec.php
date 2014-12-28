<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\VCSBundle\Controller\Webhook;

use Doctrine\ORM\EntityManager;
use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use Kreta\Component\VCS\Serializer\Interfaces\SerializerInterface;
use Kreta\Component\VCS\WebhookStrategy\GithubWebhookStrategy;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class GithubWebhookControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\VCSBundle\Controller\Webhook\GithubWebhookController');
    }

    function it_responds_to_webhook(Request $request, ContainerInterface $container, GithubWebhookStrategy $strategy,
                                    SerializerInterface $serializer, RegistryInterface $registry,
                                    EntityManager $manager, CommitInterface $entity)
    {
        $this->setContainer($container);
        $container->get('kreta_vcs.webhook_strategy.github')->shouldBeCalled()->willReturn($strategy);
        $strategy->getSerializer($request)->shouldBeCalled()->willReturn($serializer);
        $serializer->deserialize(Argument::any())->shouldBeCalled()->willReturn($entity);

        $container->has('doctrine')->shouldBeCalled()->willReturn(true);
        $container->get('doctrine')->shouldBeCalled()->willReturn($registry);
        $registry->getManager()->shouldBeCalled()->willReturn($manager);
        $manager->persist($entity)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->webhookAction($request);
    }
} 
