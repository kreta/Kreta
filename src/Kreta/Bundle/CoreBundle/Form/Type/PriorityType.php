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
 * Class PriorityType.
 *
 * @package Kreta\Bundle\CoreBundle\Form\Type
 */
class PriorityType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                IssueInterface::PRIORITY_LOW     => 'Low',
                IssueInterface::PRIORITY_MEDIUM  => 'Medium',
                IssueInterface::PRIORITY_HIGH    => 'High',
                IssueInterface::PRIORITY_BLOCKER => 'Blocker',
            )
        ));
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
        return 'kreta_core_priority_type';
    }
}
