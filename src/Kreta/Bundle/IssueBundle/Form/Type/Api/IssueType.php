<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\IssueBundle\Form\Type\Api;

use Kreta\Bundle\IssueBundle\Form\Type\IssueType as BaseIssueType;
use Kreta\Component\Issue\Factory\IssueFactory;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class IssueType.
 *
 * @package Kreta\Bundle\IssueBundle\Form\Type\Api
 */
class IssueType extends BaseIssueType
{
    /**
     * The context.
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $context;

    /**
     * The issue factory.
     *
     * @var \Kreta\Component\Issue\Factory\IssueFactory
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
     * @param \Symfony\Component\Security\Core\SecurityContextInterface  $context      The context
     * @param \Kreta\Component\Issue\Factory\IssueFactory                $issueFactory The issue factory
     */
    public function __construct(ProjectInterface $project, SecurityContextInterface $context, IssueFactory $issueFactory)
    {
        parent::__construct($project->getParticipants());
        $this->context = $context;
        $this->factory = $issueFactory;
        $this->project = $project;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'Kreta\Component\Issue\Model\Issue',
            'csrf_protection'    => false,
            'empty_data'         => function () {
                $user = $this->context->getToken()->getUser();
                if (!($user instanceof UserInterface)) {
                    throw new \Exception('User is not logged');
                }

                return $this->factory->create($this->project, $user);
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
