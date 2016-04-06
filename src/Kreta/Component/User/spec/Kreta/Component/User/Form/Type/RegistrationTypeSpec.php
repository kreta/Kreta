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

namespace spec\Kreta\Component\User\Form\Type;

use Kreta\Component\User\Factory\UserFactory;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormBuilder;

/**
 * Class RegistrationTypeSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class RegistrationTypeSpec extends ObjectBehavior
{
    function let(UserFactory $factory)
    {
        $this->beConstructedWith('Kreta\Component\User\Model\User', $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\User\Form\Type\RegistrationType');
    }

    function it_extends_kreta_abstract_type()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Type\Abstracts\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add('plainPassword', 'Symfony\Component\Form\Extension\Core\Type\RepeatedType')
            ->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }
}
