<?php

namespace spec\Kreta\Component\Notification\Model;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotificationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\Model\Notification');
    }

    function its_id_is_mutable()
    {
        $this->setId('1111')->shouldReturn($this);
        $this->getId()->shouldReturn('1111');
    }

    function its_date_is_mutable()
    {
        $date = new \Datetime();

        $this->setDate($date)->shouldReturn($this);
        $this->getDate()->shouldReturn($date);
    }

    function its_description_is_mutable()
    {
        $this->setDescription('This is the description')->shouldReturn($this);
        $this->getDescription()->shouldReturn('This is the description');
    }

    function its_project_is_mutable(ProjectInterface $project)
    {
        $this->setProject($project)->shouldReturn($this);
        $this->getProject()->shouldReturn($project);
    }

    function its_readed_is_mutable()
    {
        $this->setRead(true)->shouldReturn($this);
        $this->isRead()->shouldReturn(true);
    }

    function its_resource_url_is_mutable()
    {
        $this->setResourceUrl('/projects/1221312/issue/1982')->shouldReturn($this);
        $this->getResourceUrl()->shouldReturn('/projects/1221312/issue/1982');
    }

    function its_title_is_mutable()
    {
        $this->setTitle('Title!')->shouldReturn($this);
        $this->getTitle()->shouldReturn('Title!');
    }

    function its_type_is_mutable()
    {
        $this->setType('issue_new')->shouldReturn($this);
        $this->getType()->shouldReturn('issue_new');
    }

    function its_user_is_mutable(UserInterface $user)
    {
        $this->setUser($user)->shouldReturn($this);
        $this->getUser()->shouldReturn($user);
    }

    function its_web_url_is_mutable()
    {
        $this->setWebUrl('/issue/1982')->shouldReturn($this);
        $this->getWebUrl()->shouldReturn('/issue/1982');
    }
}
