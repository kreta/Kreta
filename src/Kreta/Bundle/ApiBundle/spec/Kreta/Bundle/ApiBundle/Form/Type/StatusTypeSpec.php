<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ApiBundle\Form\Type;

use Finite\State\StateInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class StatusTypeSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Form\Type
 */
class StatusTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Form\Type\StatusType');
    }

    function it_extends_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_builds_a_form(FormBuilderInterface $builder)
    {
        $builder->add('color', null, [
            'required' => true,
        ])->shouldBeCalled()->willReturn($builder);

        $builder->add('name', null, [
            'required' => true,
        ])->shouldBeCalled()->willReturn($builder);

        $builder->add('type', 'choice', [
            'required' => true,
            'choices'  => [
                StateInterface::TYPE_INITIAL => 'initial',
                StateInterface::TYPE_NORMAL  => 'normal',
                StateInterface::TYPE_FINAL   => 'final'
            ]
        ])->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('');
    }
}
