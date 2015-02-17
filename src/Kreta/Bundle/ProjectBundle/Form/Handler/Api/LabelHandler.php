<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Form\Handler\Api;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;
use Kreta\Bundle\ProjectBundle\Form\Type\Api\LabelType;
use Kreta\Component\Project\Factory\LabelFactory;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;

/**
 * Class LabelHandler.
 *
 * @package Kreta\Bundle\ProjectBundle\Form\Handler\Api
 */
class LabelHandler extends AbstractHandler
{
    /**
     * The label factory.
     *
     * @var \Kreta\Component\Project\Factory\LabelFactory
     */
    protected $factory;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactory                         $formFactory     The form factory
     * @param \Doctrine\Common\Persistence\ObjectManager                  $manager         The manager
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher The event dispatcher
     * @param \Kreta\Component\Project\Factory\LabelFactory               $labelFactory    The label factory
     */
    public function __construct(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        LabelFactory $labelFactory
    )
    {
        parent::__construct($formFactory, $manager, $eventDispatcher);
        $this->factory = $labelFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function createForm($object = null, array $formOptions = [])
    {
        if (!array_key_exists('project', $formOptions)) {
            throw new ParameterNotFoundException('project');
        }

        $project = $formOptions['project'];
        unset($formOptions['project']);

        return $this->formFactory->create(new LabelType($project, $this->factory), $object, $formOptions);
    }
}
