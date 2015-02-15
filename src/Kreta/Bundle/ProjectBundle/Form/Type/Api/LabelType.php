<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Form\Type\Api;

use Kreta\Component\Project\Factory\LabelFactory;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class LabelType.
 *
 * @package Kreta\Bundle\ProjectBundle\Form\Type\Api
 */
class LabelType extends AbstractType
{
    /**
     * The project factory.
     *
     * @var \Kreta\Component\Project\Factory\ProjectFactory
     */
    protected $factory;

    /**
     * The project.
     *
     * @var \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    protected $project;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project      The project
     * @param \Kreta\Component\Project\Factory\LabelFactory              $labelFactory The label factory
     */
    public function __construct(ProjectInterface $project, LabelFactory $labelFactory)
    {
        $this->project = $project;
        $this->factory = $labelFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\Project\Model\Label',
            'csrf_protection' => false,
            'empty_data'      => function (FormInterface $form) {
                return $this->factory->create($this->project, $form->get('name')->getData());
            }
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
