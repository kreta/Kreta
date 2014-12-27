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

use Symfony\Component\HttpFoundation\Request;

/**
 * Class GithubWebhookStrategy
 *
 * @package Kreta\Component\VCS\WebhookStrategy
 */
class GithubWebhookStrategy extends AbstractWebhookStrategy
{
    /**
     * {@inheritdoc}
     */
    public function getSerializer(Request $request)
    {
        $event = $request->headers->get('X-Github-Event');

        return $this->serializerRegistry->getSerializer('github', $event);
    }
}
