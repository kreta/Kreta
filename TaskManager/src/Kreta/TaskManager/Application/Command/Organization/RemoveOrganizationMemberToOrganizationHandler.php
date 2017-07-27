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

declare(strict_types=1);

namespace Kreta\TaskManager\Application\Command\Organization;

use Kreta\TaskManager\Domain\Model\Organization\Member;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\Owner;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedOrganizationActionException;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskSpecificationFactory;
use Kreta\TaskManager\Domain\Model\User\UserId;

class RemoveOrganizationMemberToOrganizationHandler
{
    private $repository;
    private $taskRepository;
    private $taskSpecificationFactory;

    public function __construct(
        OrganizationRepository $repository,
        TaskRepository $taskRepository,
        TaskSpecificationFactory $taskSpecificationFactory
    ) {
        $this->repository = $repository;
        $this->taskRepository = $taskRepository;
        $this->taskSpecificationFactory = $taskSpecificationFactory;
    }

    public function __invoke(RemoveOrganizationMemberToOrganizationCommand $command) : void
    {
        $organizationId = OrganizationId::generate($command->organizationId());
        $removerId = UserId::generate($command->removerId());
        $userId = UserId::generate($command->userId());

        $organization = $this->repository->organizationOfId($organizationId);

        $this->checkOrganizationExists($organization);
        $this->checkRemoverIsOwner($organization, $removerId);

        $this->moveTaskReferencesFromUserToRemover($organization, $userId, $removerId);
        $organization->removeOrganizationMember($userId);

        $this->repository->persist($organization);
    }

    private function checkOrganizationExists(?Organization $organization) : void
    {
        if (null === $organization) {
            throw new OrganizationDoesNotExistException();
        }
    }

    private function checkRemoverIsOwner(Organization $organization, UserId $removerId) : void
    {
        if (!$organization->isOwner($removerId)) {
            throw new UnauthorizedOrganizationActionException();
        }
    }

    private function moveTaskReferencesFromUserToRemover(
        Organization $organization,
        UserId $userId,
        UserId $removerId
    ) : void {
        $member = $organization->organizationMember($userId);
        $remover = $organization->owner($removerId);

        $this->moveTaskReferencesFromAssigneeToRemover($member, $remover);
        $this->moveTaskReferencesFromCreatorToRemover($member, $remover);
    }

    private function moveTaskReferencesFromAssigneeToRemover(Member $assignee, Owner $remover) : void
    {
        $tasks = $this->tasksOfAssignee($assignee);
        array_map(function (Task $task) use ($assignee, $remover) {
            $task->reassign($remover->id());
        }, $tasks);
    }

    private function tasksOfAssignee(Member $assignee) : array
    {
        $tasks = $this->taskRepository->query(
            $this->taskSpecificationFactory->buildByAssigneeSpecification(
                $assignee->id()
            )
        );

        return $tasks;
    }

    private function moveTaskReferencesFromCreatorToRemover(Member $creator, Owner $remover) : void
    {
        $tasks = $this->tasksOfCreator($creator);
        array_map(function (Task $task) use ($creator, $remover) {
            $task->changeReporter($remover->id());
        }, $tasks);
    }

    private function tasksOfCreator(Member $creator) : array
    {
        $tasks = $this->taskRepository->query(
            $this->taskSpecificationFactory->buildByCreatorSpecification(
                $creator->id()
            )
        );

        return $tasks;
    }
}
