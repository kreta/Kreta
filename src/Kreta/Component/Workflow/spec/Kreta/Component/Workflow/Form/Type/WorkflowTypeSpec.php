<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Workflow\Form\Type;

use Kreta\Component\Workflow\Factory\WorkflowFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class WorkflowTypeSpec.
 *
 * @package spec\Kreta\Component\Workflow\Form\Type
 */
class WorkflowTypeSpec extends ObjectBehavior
{
    function let(
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user,
        WorkflowFactory $factory
    )
    {
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('Kreta\Component\Workflow\Model\Workflow', $factory, $context);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Workflow\Form\Type\WorkflowType');
    }

    function it_extends_kreta_abstract_type()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Type\Abstracts\AbstractType');
    }

    function it_builds_a_form(FormBuilderInterface $builder)
    {
        $builder->add('name', 'text')->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_workflow_workflow_type');
    }
}
