<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\TimeTrackingBundle\Form\Type;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\TimeTracking\Factory\TimeEntryFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TimeEntryTypeSpec.
 *
 * @package spec\Kreta\Bundle\TimeTrackingBundle\Form\Type
 */
class TimeEntryTypeSpec extends ObjectBehavior
{
    function let(IssueInterface $issue, TimeEntryFactory $factory)
    {
        $this->beConstructedWith($issue, $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\TimeTrackingBundle\Form\Type\TimeEntryType');
    }

    function it_extends_form_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add('description', 'textarea', ['required' => false])->shouldBeCalled()->willReturn($builder);
        $builder->add('timeSpent', 'integer')->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_sets_default_options(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\TimeTracking\Model\TimeEntry',
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
