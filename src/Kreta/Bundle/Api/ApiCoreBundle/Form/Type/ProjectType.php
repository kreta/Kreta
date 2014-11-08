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

use Kreta\Bundle\WebBundle\Form\Type\ProjectType as BaseProjectType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ProjectType.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Form\Type
 */
class ProjectType extends BaseProjectType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'required' => true,
            ))
            ->add('shortName', 'text', array(
                'required' => true,
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
