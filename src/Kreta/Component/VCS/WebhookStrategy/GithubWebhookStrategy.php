<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\WebhookStrategy;

use Kreta\Component\VCS\Serializer\Github\CommitSerializer;
use Kreta\Component\VCS\WebhookStrategy\Interfaces\WebhookStrategyInterface;
use Symfony\Component\HttpFoundation\Request;

class GithubWebhookStrategy implements WebhookStrategyInterface
{
    protected $commitSerializer;

    public function __construct(CommitSerializer $commitSerializer)
    {
        $this->commitSerializer = $commitSerializer;
    }
    /**
     * {@inheritdoc}
     */
    public function getSerializer(Request $request)
    {
        $event = $request->headers->get('X-Github-Event');
        if ('push' === $event) {
            return $this->commitSerializer;
        }

        throw new \Exception('Event strategy not implemented');
    }
}
