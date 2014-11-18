<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\Form\Type;

use Kreta\Component\Core\Model;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class IssueType.
 *
 * @package Kreta\Bundle\WebBundle\Form\Type
 */
class IssueType extends AbstractType
{
    /** @var \Kreta\Component\Core\Model\User[] */
    protected $users;

    /**
     * @param \Kreta\Component\Core\Model\Interfaces\ParticipantInterface[] $participants Collection of participants
     */
    public function __construct($participants)
    {
        $users = array();
        foreach ($participants as $participant) {
            $users[] = $participant->getUser();
        }

        $this->users = $users;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'Name'
            ))
            ->add('description', 'textarea', array(
                'required' => false,
                'label' => 'Description'
            ))
            ->add('type', new TypeType(), array(
                'label' => 'Type'
            ))
            ->add('priority', new PriorityType(), array(
                'label' => 'Priority'
            ))
            ->add('assignee', null, array(
                'label' => 'Assignee',
                'empty_value' => null,
                'choices' => $this->users,
                'property' => 'fullName'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_core_issue_type';
    }
}
