<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Issue\Form\Type;

use Kreta\Component\Issue\Factory\IssueFactory;
use Kreta\Component\Issue\Form\Type\IssueType;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class IssueTypeSpec.
 *
 * @package sspec\Kreta\Component\Issue\Form\Type
 */
class IssueTypeSpec extends ObjectBehavior
{
    function let(TokenStorageInterface $context, TokenInterface $token, UserInterface $user, IssueFactory $factory)
    {
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('Kreta\Component\Issue\Model\Issue', $factory, $context);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Issue\Form\Type\IssueType');
    }

    function it_extends_kreta_abstract_type()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Type\Abstracts\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder, ProjectInterface $project)
    {
        $builder->add('title', 'text')->shouldBeCalled()->willReturn($builder);
        $builder->add('description', 'textarea', ['required' => false,])->shouldBeCalled()->willReturn($builder);
        $builder->add('project', 'entity', [
            'class'           => 'Kreta\Component\Project\Model\Project',
            'choices'         => [$project],
            'invalid_message' => IssueType::PROJECT_INVALID_MESSAGE
        ])->shouldBeCalled()->willReturn($builder);

        $builder->get('project')->shouldBeCalled()->willReturn($builder);
        $builder->addEventListener(FormEvents::POST_SUBMIT, Argument::type('closure'))
            ->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, ['projects' => [$project]]);
    }

    function it_sets_default_options(OptionsResolver $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('data_class', 'Kreta\Component\Issue\Model\Issue'))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('csrf_protection', false))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('empty_data', Argument::type('closure')))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(['projects' => []])->shouldBeCalled()->willReturn($resolver);

        $this->configureOptions($resolver);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_issue_issue_type');
    }
}
