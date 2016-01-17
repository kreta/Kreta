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

namespace spec\Kreta\Component\Project\Form\Type;

use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RoleTypeSpec.
 *
 * @package spec\Kreta\Bundle\ProjectBundle\Form\Type
 */
class RoleTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Form\Type\RoleType');
    }

    function it_extends_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_sets_default_options(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices'           => [
                ParticipantInterface::ADMIN       => 'ROLE_ADMIN',
                ParticipantInterface::PARTICIPANT => 'ROLE_PARTICIPANT',
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
