<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\TimeTrackingBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Bundle\CoreBundle\spec\Kreta\Bundle\CoreBundle\Controller\BaseRestController;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Issue\Repository\IssueRepository;
use Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface;
use Kreta\Component\TimeTracking\Repository\TimeEntryRepository;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class TimeEntryControllerSpec.
 *
 * @package spec\Kreta\Bundle\TimeTrackingBundle\Controller
 */
class TimeEntryControllerSpec extends BaseRestController
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\TimeTrackingBundle\Controller\TimeEntryController');
    }

    function it_extends_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Controller\RestController');
    }

    function it_does_not_get_time_entries_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext,
        ParamFetcher $paramFetcher
    )
    {
        $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('getTimeEntriesAction', ['issue-id', $paramFetcher]);
    }

    function it_gets_time_entries(
        ContainerInterface $container,
        TimeEntryRepository $timeEntryRepository,
        IssueRepository $issueRepository,
        SecurityContextInterface $securityContext,
        ParamFetcher $paramFetcher,
        IssueInterface $issue,
        TimeEntryInterface $timeEntry
    )
    {
        $issue = $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $securityContext);
        $container->get('kreta_time_tracking.repository.time_entry')
            ->shouldBeCalled()->willReturn($timeEntryRepository);
        $paramFetcher->get('sort')->shouldBeCalled()->willReturn('dateReported');
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);

        $timeEntryRepository->findByIssue($issue, ['dateReported' => 'ASC'], 10, 1)
            ->shouldBeCalled()->willReturn([$timeEntry]);

        $this->getTimeEntriesAction('issue-id', $paramFetcher)->shouldReturn([$timeEntry]);
    }

    function it_does_not_get_time_entry_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext
    )
    {
        $this->getIssueIfAllowedSpec(
            $container, $issueRepository, $issue, $securityContext, 'view', false
        );

        $this->shouldThrow(new AccessDeniedException())
            ->during('getTimeEntryAction', ['issue-id', 'time-entry-id']);
    }

    function it_gets_time_entry(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $context,
        TimeEntryRepository $timeEntryRepository,
        TimeEntryInterface $timeEntry
    )
    {
        $timeEntry = $this->getTimeEntryIfAllowedSpec(
            $container,
            $issueRepository,
            $issue,
            $context,
            $timeEntryRepository,
            $timeEntry
        );

        $this->getTimeEntryAction('issue-id', 'time-entry-id')->shouldReturn($timeEntry);
    }

    function it_does_not_post_time_entry_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $context
    )
    {
        $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $context, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('postTimeEntriesAction', ['issue-id']);
    }

    function it_posts_time_entry(
        ContainerInterface $container,
        Request $request,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        Handler $handler,
        TimeEntryInterface $timeEntry,
        SecurityContextInterface $context,
        Request $request
    )
    {
        $issue = $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $context);
        $container->get('request')->shouldBeCalled()->willReturn($request);

        $container->get('kreta_time_tracking.form_handler.time_entry')
            ->shouldBeCalled()->willReturn($handler);
        $handler->processForm($request, null, ['issue' => $issue])
            ->shouldBeCalled()->willReturn($timeEntry);

        $this->postTimeEntriesAction('issue-id')->shouldReturn($timeEntry);
    }

    function it_does_not_put_time_entry_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $context
    )
    {
        $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $context, 'view', false);

        $this->shouldThrow(new AccessDeniedException())
            ->during('putTimeEntriesAction', ['issue-id', 'time-entry-id']);
    }

    function it_puts_time_entry(
        ContainerInterface $container,
        Request $request,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        Handler $handler,
        TimeEntryInterface $timeEntry,
        SecurityContextInterface $context,
        TimeEntryRepository $timeEntryRepository,
        Request $request
    )
    {
        $timeEntry = $this->getTimeEntryIfAllowedSpec(
            $container,
            $issueRepository,
            $issue,
            $context,
            $timeEntryRepository,
            $timeEntry,
            'view',
            'edit'
        );
        $container->get('request')->shouldBeCalled()->willReturn($request);

        $container->get('kreta_time_tracking.form_handler.time_entry')
            ->shouldBeCalled()->willReturn($handler);
        $timeEntry->getIssue()->shouldBeCalled()->willReturn($issue);
        $handler->processForm($request, $timeEntry, ['method' => 'PUT', 'issue' => $issue])
            ->shouldBeCalled()->willReturn($timeEntry);

        $this->putTimeEntriesAction('issue-id', 'time-entry-id')->shouldReturn($timeEntry);
    }

    function it_does_not_delete_time_entry_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $context
    )
    {
        $this->getIssueIfAllowedSpec(
            $container, $issueRepository, $issue, $context, 'view', false
        );

        $this->shouldThrow(new AccessDeniedException())
            ->during('deleteTimeEntriesAction', ['issue-id', 'time-entry-id']);
    }

    function it_deletes_time_entry(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        TimeEntryInterface $timeEntry,
        SecurityContextInterface $context,
        TimeEntryRepository $timeEntryRepository
    )
    {
        $timeEntry = $this->getTimeEntryIfAllowedSpec(
            $container,
            $issueRepository,
            $issue,
            $context,
            $timeEntryRepository,
            $timeEntry,
            'view',
            'delete'
        );
        $container->get('kreta_time_tracking.repository.time_entry')
            ->shouldBeCalled()->willReturn($timeEntryRepository);
        $timeEntryRepository->remove($timeEntry)->shouldBeCalled();

        $this->deleteTimeEntriesAction('issue-id', 'time-entry-id');
    }

    protected function getTimeEntryIfAllowedSpec(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $context,
        TimeEntryRepository $timeEntryRepository,
        $timeEntry = null,
        $grant = 'view',
        $timeEntryGrant = 'view',
        $result = true
    )
    {
        $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $context, $grant, $result);
        $container->get('kreta_time_tracking.repository.time_entry')
            ->shouldBeCalled()->willReturn($timeEntryRepository);
        $timeEntryRepository->find('time-entry-id', false)->shouldBeCalled()->willReturn($timeEntry);
        $container->get('security.context')->shouldBeCalled()->willReturn($context);
        $context->isGranted($timeEntryGrant, $timeEntry)->shouldBeCalled()->willReturn($timeEntry);

        return $timeEntry;
    }
}
