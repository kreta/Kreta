<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\TimeTrackingBundle\Form\Type;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\TimeTracking\Factory\TimeEntryFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TimeEntryType.
 *
 * @package Kreta\Bundle\TimeTrackingBundle\Form\Type
 */
class TimeEntryType extends AbstractType
{
    /**
     * The issue factory.
     *
     * @var \Kreta\Component\TimeTracking\Factory\TimeEntryFactory
     */
    protected $factory;

    /**
     * The project.
     *
     * @var \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    protected $issue;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface $issue   The issue
     * @param \Kreta\Component\TimeTracking\Factory\TimeEntryFactory $factory The time entry factory
     */
    public function __construct(IssueInterface $issue, TimeEntryFactory $factory)
    {
        $this->factory = $factory;
        $this->issue = $issue;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea', ['required' => false])
            ->add('timeSpent', 'integer');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\TimeTracking\Model\TimeEntry',
            'csrf_protection' => false,
            'empty_data'      => function () {
                return $this->factory->create($this->issue);
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
