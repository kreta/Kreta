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

use Kreta\Bundle\ProjectBundle\Form\Type\ProjectType as BaseProjectType;
use Kreta\Component\Project\Factory\ProjectFactory;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Repository\WorkflowRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ProjectType.
 *
 * @package Kreta\Bundle\ApiBundle\Form\Type
 */
class ProjectType extends BaseProjectType
{
    /**
     * The context.
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $context;

    /**
     * The project factory.
     *
     * @var \Kreta\Component\Project\Factory\ProjectFactory
     */
    protected $factory;

    /**
     * The workflow repository.
     *
     * @var \Kreta\Component\Workflow\Repository\WorkflowRepository
     */
    protected $workflowRepository;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $context            The context
     * @param \Kreta\Component\Project\Factory\ProjectFactory           $projectFactory     The project factory
     * @param \Kreta\Component\Workflow\Repository\WorkflowRepository   $workflowRepository The workflow repository
     */
    public function __construct(
        SecurityContextInterface $context,
        ProjectFactory $projectFactory,
        WorkflowRepository $workflowRepository
    )
    {
        $this->context = $context;
        $this->factory = $projectFactory;
        $this->workflowRepository = $workflowRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('workflow', 'entity', [
                'class'    => 'Kreta\Component\Workflow\Model\Workflow',
                'required' => false,
                'mapped'   => false
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\Project\Model\Project',
            'csrf_protection' => false,
            'empty_data'      => function (FormInterface $form) {
                $user = $this->context->getToken()->getUser();
                if (!($user instanceof UserInterface)) {
                    throw new \Exception('User is not logged');
                }

                $workflowId = $form->get('workflow')->getData() ? $form->get('workflow')->getData() : 'non-exist-id';
                $workflow = $this->workflowRepository->find($workflowId);

                return $this->factory->create($user, $workflow);
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
