<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ProjectBundle\Form\Type\Api;

use Kreta\Bundle\ProjectBundle\Form\Type\Api\RoleType;
use Kreta\Component\Project\Factory\ParticipantFactory;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\User\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ParticipantTypeSpec.
 *
 * @package spec\Kreta\Bundle\ProjectBundle\Form\Type\Api
 */
class ParticipantTypeSpec extends ObjectBehavior
{
    function let(
        SecurityContextInterface $context,
        ProjectInterface $project,
        ParticipantFactory $factory,
        UserRepository $userRepository,
        UserInterface $user
    )
    {
        $userRepository->findAll()->shouldBeCalled()->willReturn([$user]);
        $this->beConstructedWith($context, $project, $factory, $userRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ProjectBundle\Form\Type\Api\ParticipantType');
    }

    function it_extends_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder, UserInterface $user)
    {
        $builder->add('role', new RoleType())->shouldBeCalled()->willReturn($builder);
        $builder->add('user', 'entity', [
            'class'   => 'Kreta\Component\User\Model\User',
            'choices' => [$user]
        ])->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_sets_default_options(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\Project\Model\Participant',
            'csrf_protection' => false,
            'empty_data'      => Argument::type('closure')
        ]);

        $this->setDefaultOptions($resolver);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('');
    }
}
