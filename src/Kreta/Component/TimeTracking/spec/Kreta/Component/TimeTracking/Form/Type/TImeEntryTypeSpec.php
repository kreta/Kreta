<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\TimeTracking\Form\Type;

use Kreta\Component\TimeTracking\Factory\TimeEntryFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TimeEntryTypeSpec.
 *
 * @package spec\Kreta\Component\TimeTracking\Form\Type
 */
class TimeEntryTypeSpec extends ObjectBehavior
{
    function let(
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user,
        TimeEntryFactory $factory
    )
    {
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('Kreta\Component\TimeTracking\Model\TimeEntry', $factory, $context);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\TimeTracking\Form\Type\TimeEntryType');
    }

    function it_extends_kreta_abstract_type()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Type\Abstracts\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add('description', 'textarea', ['required' => false])->shouldBeCalled()->willReturn($builder);
        $builder->add('timeSpent', 'integer')->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_sets_default_options(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('data_class', 'Kreta\Component\TimeTracking\Model\TimeEntry'))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('csrf_protection', false))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('empty_data', Argument::type('closure')))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setRequired(['issue'])->shouldBeCalled()->willReturn($resolver);

        $this->setDefaultOptions($resolver);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_time_tracking_time_entry_type');
    }
}
