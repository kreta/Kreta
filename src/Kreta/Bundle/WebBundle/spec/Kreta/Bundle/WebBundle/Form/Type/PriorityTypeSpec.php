<?php

namespace spec\Kreta\Bundle\WebBundle\Form\Type;

use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PriorityTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Form\Type\PriorityType');
    }

    function it_extends_form_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_sets_defaults(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                IssueInterface::PRIORITY_LOW => 'Low',
                IssueInterface::PRIORITY_MEDIUM => 'Medium',
                IssueInterface::PRIORITY_HIGH => 'High',
                IssueInterface::PRIORITY_BLOCKER => 'Blocker',
            )
        ))->shouldBeCalled();

        $this->setDefaultOptions($resolver);
    }

    function it_gets_parent()
    {
        $this->getParent()->shouldReturn('choice');
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_core_priority_type');
    }
}
