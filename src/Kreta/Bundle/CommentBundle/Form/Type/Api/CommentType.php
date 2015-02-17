<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CommentBundle\Form\Type\Api;

use Kreta\Bundle\CommentBundle\Form\Type\CommentType as BaseCommentType;
use Kreta\Component\Comment\Factory\CommentFactory;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class CommentType.
 *
 * @package Kreta\Bundle\CommentBundle\Form\Type\Api
 */
class CommentType extends BaseCommentType
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
     * @var \Kreta\Component\Comment\Factory\CommentFactory
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
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface    $issue   The issue
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $context The context
     * @param \Kreta\Component\Comment\Factory\CommentFactory           $factory The comment factory
     */
    public function __construct(IssueInterface $issue, SecurityContextInterface $context, CommentFactory $factory)
    {
        $this->context = $context;
        $this->factory = $factory;
        $this->issue = $issue;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\Comment\Model\Comment',
            'csrf_protection' => false,
            'empty_data'      => function () {
                $user = $this->context->getToken()->getUser();
                if (!($user instanceof UserInterface)) {
                    throw new \Exception('User is not logged');
                }

                return $this->factory->create($this->issue, $user);
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
