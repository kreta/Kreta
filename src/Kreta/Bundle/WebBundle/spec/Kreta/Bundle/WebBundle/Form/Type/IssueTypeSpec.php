<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\WebBundle\Form\Type;

use Kreta\Bundle\WebBundle\Form\Type\PriorityType;
use Kreta\Bundle\WebBundle\Form\Type\TypeType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;

/**
 * Class IssueTypeSpec.
 *
 * @package spec\Kreta\Bundle\WebBundle\Form\Type
 */
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
        $builder->add('project', 'entity', array(
            'label'    => 'Project',
            'class'    => 'Kreta\Component\Core\Model\Project',
            'property' => 'name'
        ))->shouldBeCalled()->willReturn($builder);

        $builder->add('title', 'text', array(
            'required' => true,
            'label'    => 'Name'
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

        $builder->add('status', 'entity', array(
            'label'    => 'Status',
            'class'    => 'Kreta\Component\Core\Model\Status',
            'property' => 'description'
        ))->shouldBeCalled()->willReturn($builder);

        $builder->add('assignee', null, array(
            'label' => 'Assignee',
            'empty_value' => null
        ))->shouldBeCalled()->willReturn($builder);


        $this->buildForm($builder, array());
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_core_issue_type');
    }
}
