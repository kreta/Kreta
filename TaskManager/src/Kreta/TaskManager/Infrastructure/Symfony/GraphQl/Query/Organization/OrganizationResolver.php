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

namespace Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Organization;

use Kreta\SharedKernel\Application\QueryBus;
use Kreta\SharedKernel\Http\GraphQl\Resolver;
use Kreta\TaskManager\Application\Query\Organization\OrganizationOfIdQuery;
use Kreta\TaskManager\Application\Query\Organization\OrganizationOfSlugQuery;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedOrganizationActionException;
use Overblog\GraphQLBundle\Error\UserError;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrganizationResolver implements Resolver
{
    private $queryBus;
    private $currentUser;

    public function __construct(TokenStorageInterface $tokenStorage, QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
        $this->currentUser = $tokenStorage->getToken()->getUser()->getUsername();
    }

    public function resolve($args)
    {
        if (isset($args['id'])) {
            return $this->byId($args['id']);
        }

        return $this->bySlug($args['slug']);
    }

    private function byId($id)
    {
        try {
            $this->queryBus->handle(
                new OrganizationOfIdQuery(
                    $id,
                    $this->currentUser
                ),
                $result
            );

            return $result;
        } catch (OrganizationDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'Does no exist any organization with the given "%s" id',
                    $id
                )
            );
        } catch (UnauthorizedOrganizationActionException $exception) {
            throw new UserError(
                sprintf(
                    'The "%s" user does not allow to access the "%s" organization',
                    $this->currentUser,
                    $id
                )
            );
        }
    }

    public function bySlug($slug)
    {
        try {
            $this->queryBus->handle(
                new OrganizationOfSlugQuery(
                    $slug,
                    $this->currentUser
                ),
                $result
            );

            return $result;
        } catch (OrganizationDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'Does no exist any organization with the given "%s" slug',
                    $slug
                )
            );
        } catch (UnauthorizedOrganizationActionException $exception) {
            throw new UserError(
                sprintf(
                    'The "%s" user does not allow to access the "%s" organization',
                    $this->currentUser,
                    $slug
                )
            );
        }
    }
}
