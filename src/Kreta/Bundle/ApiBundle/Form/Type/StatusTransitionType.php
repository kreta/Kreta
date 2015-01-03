<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class StatusTransitionType.
 *
 * @package Kreta\Bundle\ApiBundle\Form\Type
 */
class StatusTransitionType extends AbstractType
{
    /**
     * Array which contains the statuses.
     *
     * @var \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    protected $statuses;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[] $statuses Array which contains the statuses
     */
    public function __construct($statuses = [])
    {
        $this->statuses = $statuses;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null)
            ->add('state', 'entity', [
                'class' => 'Kreta\Component\Workflow\Model\Status',
                'choices' => $this->statuses,
            ])
            ->add('initials', null, [
                'mapped' => false
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'Kreta\Component\Workflow\Model\StatusTransition']);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
