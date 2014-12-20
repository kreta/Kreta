<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ProjectBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;

/**
 * Class ProjectTypeSpec.
 *
 * @package spec\Kreta\Bundle\ProjectBundle\Form\Type
 */
class ProjectTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ProjectBundle\Form\Type\ProjectType');
    }

    function it_extends_form_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add(
            'name',
            'text',
            ['label' => 'Name']
        )->shouldBeCalled()->willReturn($builder);

        $builder->add(
            'shortName',
            'text',
            ['label' => 'Short name', 'attr' => ['maxlength' => 4]]
        )->shouldBeCalled()->willReturn($builder);

        $builder->add(
            'image',
            'file',
            ['label' => 'Image', 'required' => false, 'mapped' => false]
        )->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_project_project_type');
    }
}
