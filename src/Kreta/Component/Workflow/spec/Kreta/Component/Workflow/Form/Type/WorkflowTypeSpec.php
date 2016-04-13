<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Kreta\Component\Workflow\Form\Type;

use Kreta\Component\Workflow\Factory\WorkflowFactory;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class WorkflowTypeSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class WorkflowTypeSpec extends ObjectBehavior
{
    function let(
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user,
        WorkflowFactory $factory
    ) {
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
        $builder->add('name', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }
}
