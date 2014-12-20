<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\UserBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;

/**
 * Class UserTypeSpec.
 *
 * @package spec\Kreta\Bundle\UserBundle\Form\Type
 */
class UserTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\Form\Type\UserType');
    }

    function it_extends_form_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add(
            'firstName',
            null,
            ['label' => 'First Name']
        )->shouldBeCalled()->willReturn($builder);

        $builder->add(
            'lastName',
            null,
            ['label' => 'Last Name']
        )->shouldBeCalled()->willReturn($builder);

        $builder->add(
            'email',
            null,
            ['label' => 'Email']
        )->shouldBeCalled()->willReturn($builder);

        $builder->add(
            'photo',
            'file',
            ['label' => 'Photo', 'required' => false, 'mapped' => false]
        )->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_user_user_type');
    }
}
