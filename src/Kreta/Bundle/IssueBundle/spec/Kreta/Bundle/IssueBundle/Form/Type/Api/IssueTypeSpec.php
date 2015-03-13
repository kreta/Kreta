<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\IssueBundle\Form\Type\Api;

use Kreta\Bundle\IssueBundle\Form\Type\Api\PriorityType;
use Kreta\Bundle\IssueBundle\Form\Type\Api\TypeType;
use Kreta\Component\Issue\Factory\IssueFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class IssueTypeSpec.
 *
 * @package spec\Kreta\Bundle\IssueBundle\Form\Type\Api
 */
class IssueTypeSpec extends ObjectBehavior
{
    function let(
        SecurityContextInterface $context,
        IssueFactory $issueFactory
    )
    {
        $projects = [];

        $this->beConstructedWith($projects, $context, $issueFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\IssueBundle\Form\Type\Api\IssueType');
    }

    function it_extends_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add('title', 'text')->shouldBeCalled()->willReturn($builder);
        $builder->add('description', 'textarea', ['required' => false,])->shouldBeCalled()->willReturn($builder);
        $builder->add('type', new TypeType())->shouldBeCalled()->willReturn($builder);
        $builder->add('priority', new PriorityType())->shouldBeCalled()->willReturn($builder);
        $builder->add('project', 'entity', [
            'class'    => 'Kreta\Component\Project\Model\Project',
            'choices'  => []
        ])->shouldBeCalled()->willReturn($builder);
        $builder->get('project')->shouldBeCalled()->willReturn($builder);
        $builder->addEventListener(FormEvents::POST_SUBMIT, Argument::type('closure'))
            ->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_sets_default_options(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\Issue\Model\Issue',
            'csrf_protection' => false,
            'empty_data'      => Argument::type('closure')
        ]);

        $this->setDefaultOptions($resolver);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('');
    }
}
