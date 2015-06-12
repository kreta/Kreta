<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\User\Form\Type;

use Kreta\Component\User\Factory\UserFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;

/**
 * Class ProfileTypeSpec.
 *
 * @package spec\Kreta\Component\User\Form\Type
 */
class ProfileTypeSpec extends ObjectBehavior
{
    function let(UserFactory $factory)
    {
        $this->beConstructedWith('Kreta\Component\User\Model\User', $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\User\Form\Type\ProfileType');
    }

    function it_extends_kreta_abstract_type()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Type\Abstracts\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add('username')->shouldBeCalled()->willReturn($builder);
        $builder->add('firstName')->shouldBeCalled()->willReturn($builder);
        $builder->add('lastName')->shouldBeCalled()->willReturn($builder);
        $builder->add('photo', 'file', ['required' => false, 'mapped' => false])
            ->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_user_profile_type');
    }
}
