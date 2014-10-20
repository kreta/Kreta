<?php

namespace spec\Kreta\Bundle\WebBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;

class ProjectTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Form\Type\ProjectType');
    }

    function it_extends_form_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add('name', 'text', array(
            'required' => true,
            'label' => 'Name',
        ))->shouldBeCalled()->willReturn($builder);

        $builder->add('shortName', 'text', array(
            'label' => 'Short name',
        ))->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, array());
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_core_project_type');
    }
}
