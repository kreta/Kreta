<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\Api\ApiCoreBundle\Form\Type;

use Finite\State\StateInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class StatusType.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Form\Type
 */
class StatusType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color', null, array(
                'required' => true,
            ))
            ->add('name', null, array(
                'required' => true
            ))
            ->add('type', 'choice', array(
                'required' => true,
                'choices'  => array(
                    StateInterface::TYPE_INITIAL => 'initial',
                    StateInterface::TYPE_NORMAL  => 'normal',
                    StateInterface::TYPE_FINAL   => 'final'
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
