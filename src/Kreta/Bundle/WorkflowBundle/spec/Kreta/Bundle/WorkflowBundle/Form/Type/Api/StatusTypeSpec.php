<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\WorkflowBundle\Form\Type\Api;

use Finite\State\StateInterface;
use Kreta\Component\Workflow\Factory\StatusFactory;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class StatusTypeSpec.
 *
 * @package spec\Kreta\Bundle\WorkflowBundle\Form\Type\Api
 */
class StatusTypeSpec extends ObjectBehavior
{
    function let(StatusFactory $factory, WorkflowInterface $workflow)
    {
        $this->beConstructedWith($factory, $workflow);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WorkflowBundle\Form\Type\Api\StatusType');
    }

    function it_extends_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_builds_a_form(FormBuilderInterface $builder)
    {
        $builder->add('color', null)->shouldBeCalled()->willReturn($builder);
        $builder->add('name', null)->shouldBeCalled()->willReturn($builder);

        $builder->add('type', 'choice', [
            'required' => false,
            'choices'  => [
                StateInterface::TYPE_INITIAL => 'initial',
                StateInterface::TYPE_NORMAL  => 'normal',
                StateInterface::TYPE_FINAL   => 'final'
            ]
        ])->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_sets_default_options(OptionsResolverInterface $resolver, FormInterface $form)
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\Workflow\Model\Status',
            'csrf_protection' => false,
            'empty_data'      => Argument::type('closure')
        ]); //->shouldBeCalled();

        $this->setDefaultOptions($resolver);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('');
    }
}
