<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\IssueBundle\Form\Handler\Api;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\IssueBundle\Form\Type\Api\IssueType;
use Kreta\Bundle\IssueBundle\Form\Handler\IssueHandler as BaseIssueFormHandler;
use Kreta\Component\Issue\Factory\IssueFactory;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class IssueHandler.
 *
 * @package Kreta\Bundle\IssueBundle\Form\Handler\Api
 */
class IssueHandler extends BaseIssueFormHandler
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
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactory                         $formFactory     Creates a new Form instance
     * @param \Doctrine\Common\Persistence\ObjectManager                  $manager         Persists and flush the object
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher Dispatches FormHandlerEvents
     * @param \Symfony\Component\Security\Core\SecurityContextInterface   $context         The security context
     * @param \Kreta\Component\Issue\Factory\IssueFactory                 $issueFactory    The issue factory
     */
    public function __construct(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        SecurityContextInterface $context,
        IssueFactory $issueFactory
    )
    {
        parent::__construct($formFactory, $manager, $eventDispatcher);
        $this->context = $context;
        $this->factory = $issueFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function createForm($object = null, array $formOptions = [])
    {
        if (!array_key_exists('projects', $formOptions)) {
            throw new ParameterNotFoundException('projects');
        }

        $projects = $formOptions['projects'];
        unset($formOptions['projects']);

        return $this->formFactory->create(
            new IssueType($projects, $this->context, $this->factory), $object, $formOptions
        );
    }
}
