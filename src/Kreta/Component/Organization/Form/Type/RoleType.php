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

namespace Kreta\Component\Organization\Form\Type;

use Kreta\Component\Organization\Model\Interfaces\ParticipantInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Role form type class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class RoleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices'           => [
                ParticipantInterface::ORG_ADMIN       => ParticipantInterface::ORG_ADMIN,
                ParticipantInterface::ORG_PARTICIPANT => ParticipantInterface::ORG_PARTICIPANT,
            ],
            'choices_as_values' => true,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\ChoiceType';
    }
}
