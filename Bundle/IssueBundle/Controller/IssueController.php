<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\IssueBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Annotation\ResourceIfAllowed as Issue;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class IssueController.
 *
 * @package Kreta\Bundle\IssueBundle\Controller
 */
class IssueController extends Controller
{
    /**
     * Returns all issues, it admits sort, limit and offset.
     *
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="sort", requirements="(title|createdAt)", default="title", description="Sort")
     * @QueryParam(name="project", requirements="(.*)", strict=true, nullable=true, description="Project filter")
     * @QueryParam(name="assignee", requirements="(.*)", strict=true, nullable=true, description="Assignee filter")
     * @QueryParam(name="reporter", requirements="(.*)", strict=true, nullable=true, description="Reporter filter")
     * @QueryParam(name="watcher", requirements="(.*)", strict=true, nullable=true, description="Watcher filter")
     * @QueryParam(name="priority", requirements="(.*)", strict=true, nullable=true, description="Priority filter")
     * @QueryParam(name="status", requirements="(.*)", strict=true, nullable=true, description="Status filter")
     * @QueryParam(name="type", requirements="(.*)", strict=true, nullable=true, description="Type filter")
     * @QueryParam(name="label", requirements="(.*)", strict=true, nullable=true, description="Label filter")
     * @QueryParam(name="q", requirements="(.*)", strict=true, nullable=true, description="Title filter")
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of issues to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(resource=true, statusCodes={200, 403})
     * @View(statusCode=200, serializerGroups={"issueList"})
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function getIssuesAction(ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_issue.repository.issue')->findByParticipant(
            $this->getUser(),
            [
                'title'  => $paramFetcher->get('q'),
                'p.id'   => $paramFetcher->get('project'),
                'a.id'   => $paramFetcher->get('assignee'),
                'rep.id' => $paramFetcher->get('reporter'),
                'w.id'   => $paramFetcher->get('watcher'),
                'pr.id'  => $paramFetcher->get('priority'),
                's.id'   => $paramFetcher->get('status'),
                't.id'   => $paramFetcher->get('type'),
                'l.id'   => $paramFetcher->get('label')
            ],
            [$paramFetcher->get('sort') => 'ASC'],
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
    }

    /**
     * Returns the issue of id given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     * @param string                                    $issueId The issue id
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"issue"})
     * @Issue()
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function getIssueAction(Request $request, $issueId)
    {
        return $request->get('issue');
    }

    /**
     * Creates new issue for title, description, type priority and assignee given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     *
     * @ApiDoc(statusCodes={201, 400, 403})
     * @View(statusCode=201, serializerGroups={"issue"})
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function postIssuesAction(Request $request)
    {
        $projects = $this->get('kreta_project.repository.project')->findByParticipant($this->getUser());

        return $this->get('kreta_issue.form_handler.issue')->processForm($request, null, ['projects' => $projects]);
    }

    /**
     * Updates the issue of id given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     * @param string                                    $issueId The issue id
     *
     * @ApiDoc(statusCodes={200, 400, 403, 404})
     * @View(statusCode=200, serializerGroups={"issue"})
     * @Issue("edit")
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function putIssuesAction(Request $request, $issueId)
    {
        $projects = $this->get('kreta_project.repository.project')->findByParticipant($this->getUser());

        return $this->get('kreta_issue.form_handler.issue')->processForm(
            $request, $request->get('issue'), ['method' => 'PUT', 'projects' => $projects]
        );
    }

    /**
     * Updates the issues's transition with the transition id given, if it is allowed.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     * @param string                                    $issueId The issue id
     *
     * @ApiDoc(statusCodes={200, 400, 403}, parameters={
     *  {"name"="transition", "dataType"="string", "required"=true, "description"="The transition id"}
     * })
     * @View(statusCode=200, serializerGroups={"issue"})
     * @Issue("edit")
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function patchIssuesTransitionsAction(Request $request, $issueId)
    {
        if (!$transitionId = $request->request->get('transition')) {
            throw new BadRequestHttpException('The transition id should not be blank');
        }
        $issue = $request->get('issue');
        $workflow = $issue->getProject()->getWorkflow();

        $statuses = $this->get('kreta_workflow.repository.status')->findBy(['workflow' => $workflow]);
        $transitionRepository = $this->get('kreta_workflow.repository.status_transition');
        $transitions = $transitionRepository->findBy(['workflow' => $workflow]);
        $transition = $transitionRepository->find($transitionId);

        $stateMachine = $this->get('kreta_issue.state_machine.issue')->load($issue, $statuses, $transitions);
        if (!$stateMachine->can($transition)) {
            throw new NotFoundHttpException('The requested transition cannot be applied');
        }
        $stateMachine->apply($transition->getName());
        $this->getDoctrine()->getManager()->flush();

        return $issue;
    }
}
