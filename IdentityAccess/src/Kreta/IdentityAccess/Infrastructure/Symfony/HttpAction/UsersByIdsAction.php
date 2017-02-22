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

namespace Kreta\IdentityAccess\Infrastructure\Symfony\HttpAction;

use Kreta\IdentityAccess\Application\Query\UsersOfIdsQuery;
use Kreta\SharedKernel\Application\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UsersByIdsAction
{
    private $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $ids = explode(',', $request->query->get('ids'));

        $this->queryBus->handle(
            new UsersOfIdsQuery($ids),
            $result
        );

        return new JsonResponse($result);

        return new JsonResponse([
            [
                'id'         => '61c0d185-fc68-46f2-9c5f-783dc6096029',
                'username'   => 'gorkalaucirica',
                'email'      => 'gorkgua.lauzirika@gmail.com',
                'first_name' => 'Gorka',
                'last_name'  => 'Laucirica',
                'full_name'  => 'Gorka Laucirica',
                'image'      => '/images/gorka.jpg',
            ], [
                'id'         => 'a38f8ef4-400b-4229-a5ff-712ff5f72b27',
                'username'   => 'benatespina',
                'email'      => 'benatespina@gmail.com',
                'first_name' => 'Beñat',
                'last_name'  => 'Espiña',
                'full_name'  => 'Beñat Espiña',
                'image'      => '/images/bespina.jpg',
            ],
        ]);
    }
}
