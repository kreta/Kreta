<?php

namespace spec\Kreta\Bundle\WebBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;

class CommentTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Form\Type\CommentType');
    }

    function it_extends_form_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add('description', 'textarea', array(
            'required' => true,
            'label' => false
        ))->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, array());
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_core_comment_type');
    }
}
