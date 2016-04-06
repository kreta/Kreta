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

use Kreta\Component\Organization\Model\Interfaces\ParticipantInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Spec file of RoleType class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class RoleTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Organization\Form\Type\RoleType');
    }

    function it_extends_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_sets_default_options(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices'           => [
                ParticipantInterface::ORG_ADMIN       => ParticipantInterface::ORG_ADMIN,
                ParticipantInterface::ORG_PARTICIPANT => ParticipantInterface::ORG_PARTICIPANT,
            ],
            'choices_as_values' => true,
        ])->shouldBeCalled()->willReturn($resolver);

        $this->configureOptions($resolver);
    }

    function it_gets_parent()
    {
        $this->getParent()->shouldReturn('Symfony\Component\Form\Extension\Core\Type\ChoiceType');
    }
}
