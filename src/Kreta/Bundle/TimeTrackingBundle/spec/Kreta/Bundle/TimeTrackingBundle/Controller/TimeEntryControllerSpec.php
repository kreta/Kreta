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
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface;
use Kreta\Component\TimeTracking\Repository\TimeEntryRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TimeEntryControllerSpec.
 *
 * @package spec\Kreta\Bundle\TimeTrackingBundle\Controller
 */
class TimeEntryControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\TimeTrackingBundle\Controller\TimeEntryController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_time_entries(
        ContainerInterface $container,
        Request $request,
        TimeEntryRepository $timeEntryRepository,
        ParamFetcher $paramFetcher,
        IssueInterface $issue,
        TimeEntryInterface $timeEntry
    )
    {
        $container->get('kreta_time_tracking.repository.time_entry')
            ->shouldBeCalled()->willReturn($timeEntryRepository);
        $request->get('issue')->shouldBeCalled()->willReturn($issue);
        $paramFetcher->get('sort')->shouldBeCalled()->willReturn('dateReported');
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);

        $timeEntryRepository->findByIssue($issue, ['dateReported' => 'ASC'], 10, 1)
            ->shouldBeCalled()->willReturn([$timeEntry]);

        $this->getTimeEntriesAction($request, 'issue-id', $paramFetcher)->shouldReturn([$timeEntry]);
    }

    function it_gets_time_entry(Request $request, TimeEntryInterface $timeEntry)
    {
        $request->get('timeEntry')->shouldBeCalled()->willReturn($timeEntry);

        $this->getTimeEntryAction($request, 'issue-id', 'time-entry-id')->shouldReturn($timeEntry);
    }

    function it_posts_time_entry(
        ContainerInterface $container,
        Request $request,
        IssueInterface $issue,
        Handler $handler,
        TimeEntryInterface $timeEntry,
        Request $request
    )
    {
        $container->get('kreta_time_tracking.form_handler.time_entry')->shouldBeCalled()->willReturn($handler);
        $request->get('issue')->shouldBeCalled()->willReturn($issue);
        $handler->processForm($request, null, ['issue' => $issue])->shouldBeCalled()->willReturn($timeEntry);

        $this->postTimeEntriesAction($request, 'issue-id')->shouldReturn($timeEntry);
    }

    function it_puts_time_entry(
        ContainerInterface $container,
        Request $request,
        IssueInterface $issue,
        Handler $handler,
        TimeEntryInterface $timeEntry,
        Request $request
    )
    {
        $container->get('kreta_time_tracking.form_handler.time_entry')->shouldBeCalled()->willReturn($handler);
        $request->get('timeEntry')->shouldBeCalled()->willReturn($timeEntry);
        $request->get('issue')->shouldBeCalled()->willReturn($issue);
        $handler->processForm($request, $timeEntry, ['method' => 'PUT', 'issue' => $issue])
            ->shouldBeCalled()->willReturn($timeEntry);

        $this->putTimeEntriesAction($request, 'issue-id', 'time-entry-id')->shouldReturn($timeEntry);
    }

    function it_deletes_time_entry(
        ContainerInterface $container,
        Request $request,
        TimeEntryInterface $timeEntry,
        TimeEntryRepository $timeEntryRepository
    )
    {
        $container->get('kreta_time_tracking.repository.time_entry')
            ->shouldBeCalled()->willReturn($timeEntryRepository);
        $request->get('timeEntry')->shouldBeCalled()->willReturn($timeEntry);
        $timeEntryRepository->remove($timeEntry)->shouldBeCalled();

        $this->deleteTimeEntriesAction($request, 'issue-id', 'time-entry-id');
    }
}
