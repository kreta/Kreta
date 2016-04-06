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

namespace spec\Kreta\Component\Organization\Form\Type;

use Kreta\Component\Organization\Factory\OrganizationFactory;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Spec file of OrganizationType class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationTypeSpec extends ObjectBehavior
{
    function let(TokenStorageInterface $context, TokenInterface $token, UserInterface $user, OrganizationFactory $factory)
    {
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('Kreta\Component\Organization\Model\Organization', $factory, $context);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Organization\Form\Type\OrganizationType');
    }

    function it_extends_kreta_abstract_type()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Type\Abstracts\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add('name')->shouldBeCalled()->willReturn($builder);
        $builder->add('image', 'Symfony\Component\Form\Extension\Core\Type\FileType', [
            'required' => false,
            'mapped'   => false,
        ])->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }
}
