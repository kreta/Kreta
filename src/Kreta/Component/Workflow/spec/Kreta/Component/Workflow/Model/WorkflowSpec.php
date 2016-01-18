<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Kreta\Component\Workflow\Model;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class WorkflowSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class WorkflowSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Workflow\Model\Workflow');
    }

    function it_extends_abstract_model()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Abstracts\AbstractModel');
    }

    function it_implements_workflow_interface()
    {
        $this->shouldImplement('Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface');
    }

    function its_statuses_transitions_and_projects_are_collection()
    {
        $this->getProjects()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getStatuses()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getStatusTransitions()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
    }

    function its_created_at_is_a_datetime()
    {
        $this->getCreatedAt()->shouldHaveType('DateTime');
    }

    function its_created_at_is_mutable()
    {
        $createDate = new \DateTime();

        $this->setCreatedAt($createDate)->shouldReturn($this);
        $this->getCreatedAt()->shouldReturn($createDate);
    }

    function its_creator_is_mutable(UserInterface $creator)
    {
        $this->setCreator($creator)->shouldReturn($this);
        $this->getCreator()->shouldReturn($creator);
    }

    function its_name_is_mutable()
    {
        $this->setName('Dummy name')->shouldReturn($this);
        $this->getName()->shouldReturn('Dummy name');
    }

    function its_projects_are_be_mutable(ProjectInterface $project)
    {
        $this->getProjects()->shouldHaveCount(0);

        $this->addProject($project);

        $this->getProjects()->shouldHaveCount(1);

        $this->removeProject($project);

        $this->getProjects()->shouldHaveCount(0);
    }

    function its_statuses_are_be_mutable(StatusInterface $status)
    {
        $this->getStatuses()->shouldHaveCount(0);

        $this->addStatus($status);

        $this->getStatuses()->shouldHaveCount(1);

        $this->removeStatus($status);

        $this->getStatuses()->shouldHaveCount(0);
    }

    function its_status_transitions_are_be_mutable(StatusTransitionInterface $transition)
    {
        $this->getStatusTransitions()->shouldHaveCount(0);

        $this->addStatusTransition($transition);

        $this->getStatusTransitions()->shouldHaveCount(1);

        $this->removeStatusTransition($transition);

        $this->getStatusTransitions()->shouldHaveCount(0);
    }
}
