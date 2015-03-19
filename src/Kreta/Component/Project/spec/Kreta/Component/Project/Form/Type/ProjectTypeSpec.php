<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Project\Form\Type;

use Kreta\Component\Project\Factory\ProjectFactory;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ProjectTypeSpec.
 *
 * @package spec\Kreta\Component\Project\Form\Type
 */
class ProjectTypeSpec extends ObjectBehavior
{
    function let(SecurityContextInterface $context, TokenInterface $token, UserInterface $user, ProjectFactory $factory)
    {
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('Kreta\Component\Project\Model\Project', $factory, $context);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Form\Type\ProjectType');
    }

    function it_extends_kreta_abstract_type()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Type\Abstracts\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add('name')->shouldBeCalled()->willReturn($builder);
        $builder->add('shortName')->shouldBeCalled()->willReturn($builder);
        $builder->add('image', 'file', [
            'required' => false,
            'mapped'   => false
        ])->shouldBeCalled()->willReturn($builder);
        $builder->add('workflow', 'entity', [
            'class'    => 'Kreta\Component\Workflow\Model\Workflow',
            'required' => false,
            'mapped'   => false
        ])->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_project_project_type');
    }
}
