<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CommentBundle\Form\Type\Api;

use Kreta\Component\Comment\Factory\CommentFactory;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class CommentTypeSpec.
 *
 * @package spec\Kreta\Bundle\CommentBundle\Form\Type\Api
 */
class CommentTypeSpec extends ObjectBehavior
{
    function let(IssueInterface $issue, SecurityContextInterface $context, CommentFactory $factory)
    {
        $this->beConstructedWith($issue, $context, $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CommentBundle\Form\Type\Api\CommentType');
    }

    function it_extends_comment_type()
    {
        $this->shouldHaveType('Kreta\Bundle\CommentBundle\Form\Type\CommentType');
    }

    function it_sets_default_options(
        OptionsResolverInterface $resolver,
        FormInterface $form,
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user
    )
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\Comment\Model\Comment',
            'csrf_protection' => false,
            'empty_data'      => Argument::type('closure')
        ]); //->shouldBeCalled();

        $this->setDefaultOptions($resolver);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('');
    }
}
