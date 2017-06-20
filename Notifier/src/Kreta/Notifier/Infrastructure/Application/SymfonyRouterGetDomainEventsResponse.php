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
                'count' => count($events),
                'page'  => $page,
            ],
            '_links' => [
                'first' => $this->urlGenerate(1),
                'next'  => $this->urlGenerate($page + 1),
                'self'  => $this->urlGenerate($page),
            ],
            'data'   => $events,
        ];
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
