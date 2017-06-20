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

namespace Kreta\Notifier\Infrastructure\Symfony\HttpAction;

use Kreta\Notifier\Application\GetDomainEventsQuery;
use Kreta\SharedKernel\Application\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class GetDomainEventsAction
{
    private const PAGE_SIZE = 25;
    private const CACHE_LIFETIME = 60 * 60 * 24 * 365; // 1 year

    private $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $since = $request->query->get('since');

        $this->queryBus->handle(
            new GetDomainEventsQuery(
                $page,
                self::PAGE_SIZE,
                $since
            ),
            $events
        );

        $numberOfEvents = count($events['data']);
        $isPageCompleted = $numberOfEvents === self::PAGE_SIZE;
        $response = new JsonResponse($events, 0 !== $numberOfEvents ? 200 : 404);

        if ($isPageCompleted) {
            $response
                ->setMaxAge(self::CACHE_LIFETIME)
                ->setSharedMaxAge(self::CACHE_LIFETIME);
        }

        return $response;
    }
}
