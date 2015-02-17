<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CommentBundle\Form\Handler\Api;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\CommentBundle\Form\Type\Api\CommentType;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;
use Kreta\Component\Comment\Factory\CommentFactory;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class CommentHandler.
 *
 * @package Kreta\Bundle\CommentBundle\FormHandler\Api
 */
class CommentHandler extends AbstractHandler
{
    /**
     * The context.
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $context;

    /**
     * The comment factory.
     *
     * @var \Kreta\Component\Comment\Factory\CommentFactory
     */
    protected $factory;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactory                         $formFactory     Creates a new Form instance
     * @param \Doctrine\Common\Persistence\ObjectManager                  $manager         Persists and flush the object
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher Dispatches FormHandlerEvents
     * @param \Symfony\Component\Security\Core\SecurityContextInterface   $context         The security context
     * @param \Kreta\Component\Comment\Factory\CommentFactory             $commentFactory  The comment factory
     */
    public function __construct(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        SecurityContextInterface $context,
        CommentFactory $commentFactory
    )
    {
        parent::__construct($formFactory, $manager, $eventDispatcher);
        $this->context = $context;
        $this->factory = $commentFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function createForm($object = null, array $formOptions = [])
    {
        if (!array_key_exists('issue', $formOptions)) {
            throw new ParameterNotFoundException('issue');
        }

        $issue = $formOptions['issue'];
        unset($formOptions['issue']);

        return $this->formFactory->create(
            new CommentType($issue, $this->context, $this->factory), $object, $formOptions
        );
    }
}
