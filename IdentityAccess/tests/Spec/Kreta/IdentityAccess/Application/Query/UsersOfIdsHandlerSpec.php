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

namespace Spec\Kreta\IdentityAccess\Application\Query;

use BenGorUser\User\Application\DataTransformer\UserDataTransformer;
use Kreta\IdentityAccess\Application\Query\UsersOfIdsHandler;
use Kreta\IdentityAccess\Application\Query\UsersOfIdsQuery;
use Kreta\IdentityAccess\Domain\Model\User\User;
use Kreta\IdentityAccess\Domain\Model\User\UserRepository;
use PhpSpec\ObjectBehavior;

class UsersOfIdsHandlerSpec extends ObjectBehavior
{
    function let(UserRepository $repository, UserDataTransformer $dataTransformer)
    {
        $this->beConstructedWith($repository, $dataTransformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UsersOfIdsHandler::class);
    }

    function it_gets_users_of_given_ids(
        UsersOfIdsQuery $query,
        UserRepository $repository,
        UserDataTransformer $dataTransformer,
        User $user,
        User $user2
    ) {
        $query->ids()->shouldBeCalled()->willReturn(['user-id', 'user-id-2']);

        $repository->usersOfIds(['user-id', 'user-id-2'])->shouldBeCalled()->willReturn([$user, $user2]);

        $dataTransformer->write($user)->shouldBeCalled();
        $dataTransformer->write($user2)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled()->willReturn([
            'user_id' => 'user-id',
        ]);

        $this->__invoke($query)->shouldReturn([[
            'user_id' => 'user-id',
        ], [
            'user_id' => 'user-id',
        ]]);
    }

    function it_does_not_get_users_with_empty_ids(UsersOfIdsQuery $query, UserRepository $repository)
    {
        $query->ids()->shouldBeCalled()->willReturn([]);
        $repository->usersOfIds([])->shouldBeCalled()->willReturn([]);

        $this->__invoke($query)->shouldReturn([]);
    }
}
