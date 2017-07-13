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

namespace Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Project;

use Kreta\SharedKernel\Application\QueryBus;
use Kreta\SharedKernel\Http\GraphQl\Resolver;
use Kreta\TaskManager\Application\Query\Project\ProjectOfIdQuery;
use Kreta\TaskManager\Application\Query\Project\ProjectOfSlugQuery;
use Kreta\TaskManager\Domain\Model\Project\ProjectDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedProjectResourceException;
use Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Organization\OrganizationResolver;
use Overblog\GraphQLBundle\Error\UserError;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProjectResolver implements Resolver
{
    private $queryBus;
    private $currentUser;
    private $organizationResolver;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        QueryBus $queryBus,
        OrganizationResolver $organizationResolver
    ) {
        $this->queryBus = $queryBus;
        $this->currentUser = $tokenStorage->getToken()->getUser()->getUsername();
        $this->organizationResolver = $organizationResolver;
    }

    public function resolve($args)
    {
        $result = isset($args['projectInput'])
            ? $this->byProjectInput($args['projectInput'])
            : $this->byId($args['id']);

        $result['organization'] = $this->organizationResolver->resolve([
            'id' => $result['organization_id'],
        ]);
        unset($result['organization_id']);

        return $result;
    }

    private function byId($id)
    {
        try {
            $this->queryBus->handle(
                new ProjectOfIdQuery(
                    $id,
                    $this->currentUser
                ),
                $result
            );

            return $result;
        } catch (ProjectDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'Does not exist any project with the given "%s" id',
                    $id
                )
            );
        } catch (UnauthorizedProjectResourceException $exception) {
            throw new UserError(
                sprintf(
                    'The "%s" user does not allow to access the "%s" project',
                    $this->currentUser,
                    $id
                )
            );
        }
    }

    public function byProjectInput($projectInput)
    {
        try {
            $this->queryBus->handle(
                new ProjectOfSlugQuery(
                    $projectInput['slug'],
                    $projectInput['organizationSlug'],
                    $this->currentUser
                ),
                $result
            );

            return $result;
        } catch (ProjectDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'Does not exist any project with the given "%s" slug',
                    $projectInput['slug']
                )
            );
        } catch (UnauthorizedProjectResourceException $exception) {
            throw new UserError(
                sprintf(
                    'The "%s" user does not allow to access the "%s" project',
                    $this->currentUser,
                    $projectInput['slug']
                )
            );
        }
    }
}
