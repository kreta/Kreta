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

use Kreta\Component\Workflow\Factory\StatusTransitionFactory;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\StatusRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class StatusTransitionTypeSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Form\Type
 */
class StatusTransitionTypeSpec extends ObjectBehavior
{
    function let(WorkflowInterface $workflow, StatusTransitionFactory $factory, StatusRepository $statusRepository)
    {
        $this->beConstructedWith($workflow, $factory, $statusRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Form\Type\StatusTransitionType');
    }

    function it_extends_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_builds_a_form(FormBuilderInterface $builder)
    {
        $builder->add('name', null)->shouldBeCalled()->willReturn($builder);

        $builder->add('state', 'entity', [
            'class'   => 'Kreta\Component\Workflow\Model\Status',
            'choices' => []
        ])->shouldBeCalled()->willReturn($builder);

        $builder->add('initials', null, [
            'mapped' => false
        ])->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_sets_default_options(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Kreta\Component\Workflow\Model\StatusTransition',
            'csrf_protection' => false,
            'empty_data'      => Argument::type('closure')
        ]); //->shouldBeCalled()->willReturn($resolver);

        $this->setDefaultOptions($resolver);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('');
    }
}
