<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\IssueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class IssueType.
 *
 * @package Kreta\Bundle\IssueBundle\Form\Type
 */
class IssueType extends AbstractType
{
    /** @var \Kreta\Component\User\Model\User[] */
    protected $users;

    /**
     * @param \Kreta\Component\Project\Model\Interfaces\ParticipantInterface[] $participants Collection of participants
     */
    public function __construct($participants = [])
    {
        $users = [];
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
            ->add('title', 'text', [
                'required' => true,
                'label' => 'Name'
            ])
            ->add('description', 'textarea', [
                'required' => false,
                'label' => 'Description'
            ])
            ->add('type', new TypeType(), [
                'label' => 'Type'
            ])
            ->add('priority', new PriorityType(), [
                'label' => 'Priority'
            ])
            ->add('assignee', 'entity', [
                'class' => 'Kreta\Component\User\Model\User',
                'label' => 'Assignee',
                'empty_value' => null,
                'choices' => $this->users,
                'property' => 'fullName'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_issue_issue_type';
    }
}
