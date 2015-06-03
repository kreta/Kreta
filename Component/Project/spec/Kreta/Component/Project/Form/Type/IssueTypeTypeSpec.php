<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Project\Form\Type;

use Kreta\Component\Project\Factory\IssueTypeFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class IssueTypeTypeSpec.
 *
 * @package spec\Kreta\Component\Project\Form\Type
 */
class IssueTypeTypeSpec extends ObjectBehavior
{
    function let(TokenStorageInterface $context, TokenInterface $token, UserInterface $user, IssueTypeFactory $factory)
    {
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('Kreta\Component\Project\Model\IssueType', $factory, $context);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Form\Type\IssueTypeType');
    }

    function it_extends_kreta_abstract_type()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Type\Abstracts\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add('name')->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_sets_default_options(OptionsResolver $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('data_class', 'Kreta\Component\Project\Model\IssueType'))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('csrf_protection', false))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('empty_data', Argument::type('closure')))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setRequired(['project'])->shouldBeCalled()->willReturn($resolver);

        $this->configureOptions($resolver);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_project_issue_type_type');
    }
}
