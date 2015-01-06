<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ApiBundle\Form\Type;

use Kreta\Component\Issue\Factory\IssueFactory;
use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class IssueTypeSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Form\Type
 */
class IssueTypeSpec extends ObjectBehavior
{
    function let(
        ProjectInterface $project,
        ParticipantInterface $participant,
        SecurityContextInterface $context,
        IssueFactory $issueFactory
    )
    {
        $project->getParticipants()->shouldBeCalled()->willReturn([$participant]);
        $this->beConstructedWith($project, $context, $issueFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Form\Type\IssueType');
    }

    function it_extends_issue_type()
    {
        $this->shouldHaveType('Kreta\Bundle\IssueBundle\Form\Type\IssueType');
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
            'data_class'      => 'Kreta\Component\Issue\Model\Issue',
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
