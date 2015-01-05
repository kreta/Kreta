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

use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Factory\WorkflowFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class WorkflowTypeSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Form\Type
 */
class WorkflowTypeSpec extends ObjectBehavior
{
    function let(SecurityContextInterface $context, WorkflowFactory $workflowFactory)
    {
        $this->beConstructedWith($context, $workflowFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Form\Type\WorkflowType');
    }

    function it_extends_workflow_type()
    {
        $this->shouldHaveType('Kreta\Bundle\WorkflowBundle\Form\Type\WorkflowType');
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
            'data_class'      => 'Kreta\Component\Workflow\Model\Workflow',
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
