<?php

namespace spec\Kreta\Bundle\WebBundle\Form\Type;

use Kreta\Bundle\WebBundle\Form\Type\PriorityType;
use Kreta\Bundle\WebBundle\Form\Type\TypeType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;

class IssueTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Form\Type\IssueType');
    }

    function it_extends_form_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add('project', null, array(
            'label' => 'Project'
        ))->shouldBeCalled()->willReturn($builder);

        $builder->add('title', 'text', array(
            'required' => true,
            'label' => 'Name'
        ))->shouldBeCalled()->willReturn($builder);

        $builder->add('description', 'textarea', array(
            'label' => 'Description',
        ))->shouldBeCalled()->willReturn($builder);

        $builder->add('type', new TypeType(), array(
            'label' => 'Type'
        ))->shouldBeCalled()->willReturn($builder);

        $builder->add('priority', new PriorityType(), array(
            'label' => 'Priority'
        ))->shouldBeCalled()->willReturn($builder);

        $builder->add('status', null, array(
            'label' => 'Status'
        ))->shouldBeCalled()->willReturn($builder);

        $builder->add('reporter', null, array(
            'label' => 'Assigner'
        ))->shouldBeCalled()->willReturn($builder);

        $builder->add('assignee', null, array(
            'label' => 'Assignee'
        ))->shouldBeCalled()->willReturn($builder);


        $this->buildForm($builder, array());
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_core_issue_type');
    }
}
