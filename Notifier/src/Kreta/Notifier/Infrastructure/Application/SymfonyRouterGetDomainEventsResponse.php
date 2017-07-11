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

namespace Kreta\Notifier\Infrastructure\Application;

use Kreta\Notifier\Application\GetDomainEventsResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SymfonyRouterGetDomainEventsResponse implements GetDomainEventsResponse
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function build(array $events, int $page, int $pageSize) : array
    {
        return [
            '_meta'  => [
                'count' => $this->numberOfEvents($events),
                'page'  => $page,
            ],
            '_links' => $this->links($events, $page, $pageSize),
            'data'   => $events,
        ];
    }

    private function numberOfEvents(array $events) : int
    {
        return count($events);
    }

    private function links(array $events, int $page, int $pageSize) : array
    {
        $links = [
            'first' => $this->urlGenerate(1),
            'self'  => $this->urlGenerate($page),
        ];

        if ($this->numberOfEvents($events) === $pageSize) {
            $links = array_merge(
                ['first' => $this->urlGenerate(1)],
                ['self' => $links['self']],
                ['next' => $this->urlGenerate($page + 1)]
            );
        }

        return $links;
    }

    private function urlGenerate(int $page) : string
    {
        return $this->urlGenerator->generate(
            'kreta_notifier_get_domain_events',
            ['page' => $page],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}
