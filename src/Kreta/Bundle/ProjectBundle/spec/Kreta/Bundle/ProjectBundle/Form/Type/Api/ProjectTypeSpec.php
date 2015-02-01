<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ProjectBundle\Form\Type\Api;

use Kreta\Component\Project\Factory\ProjectFactory;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Repository\WorkflowRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ProjectTypeSpec.
 *
 * @package spec\Kreta\Bundle\ProjectBundle\Form\Type\Api
 */
class ProjectTypeSpec extends ObjectBehavior
{
    function let(SecurityContextInterface $context, ProjectFactory $factory, WorkflowRepository $workflowRepository)
    {
        $this->beConstructedWith($context, $factory, $workflowRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ProjectBundle\Form\Type\Api\ProjectType');
    }

    function it_extends_project_type()
    {
        $this->shouldHaveType('Kreta\Bundle\ProjectBundle\Form\Type\ProjectType');
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

        $builder->add('workflow', 'entity', [
            'class'    => 'Kreta\Component\Workflow\Model\Workflow',
            'required' => false,
            'mapped'   => false
        ])->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_sets_default_options(
        OptionsResolverInterface $resolver,
        FormInterface $form,
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user
    )
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\Issue\Model\Issue',
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
