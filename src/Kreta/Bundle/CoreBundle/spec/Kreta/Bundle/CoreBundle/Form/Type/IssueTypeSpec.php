<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CoreBundle\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Kreta\Bundle\CoreBundle\Form\Type\PriorityType;
use Kreta\Bundle\CoreBundle\Form\Type\TypeType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;

/**
 * Class IssueTypeSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\Form\Type
 */
class IssueTypeSpec extends ObjectBehavior
{
    function let() {
        $participants = new ArrayCollection();
        $this->beConstructedWith($participants);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Form\Type\IssueType');
    }

    function it_extends_form_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add('title', 'text', [
            'required' => true,
            'label'    => 'Name'
        ])->shouldBeCalled()->willReturn($builder);

        $builder->add('description', 'textarea', [
            'required' => false,
            'label' => 'Description',
        ])->shouldBeCalled()->willReturn($builder);

        $builder->add('type', new TypeType(), [
            'label' => 'Type'
        ])->shouldBeCalled()->willReturn($builder);

        $builder->add('priority', new PriorityType(), [
            'label' => 'Priority'
        ])->shouldBeCalled()->willReturn($builder);

        $builder->add('assignee', 'entity', [
            'class' => 'Kreta\Component\Core\Model\User',
            'label' => 'Assignee',
            'empty_value' => null,
            'choices' => [],
            'property' => 'fullName'
        ])->shouldBeCalled()->willReturn($builder);


        $this->buildForm($builder, []);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_core_issue_type');
    }
}
