<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Form\Type;

use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TypeType.
 *
 * @package Kreta\Bundle\CoreBundle\Form\Type
 */
class TypeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                IssueInterface::TYPE_BUG         => 'Bug',
                IssueInterface::TYPE_NEW_FEATURE => 'New feature',
                IssueInterface::TYPE_IMPROVEMENT => 'Improvement',
                IssueInterface::TYPE_EPIC        => 'Epic',
                IssueInterface::TYPE_STORY       => 'Story'
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_core_type_type';
    }
}
