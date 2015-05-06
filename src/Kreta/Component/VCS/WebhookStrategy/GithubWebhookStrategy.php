<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\WebhookStrategy;

use Kreta\Component\VCS\WebhookStrategy\Abstracts\AbstractWebhookStrategy;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GithubWebhookStrategy.
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
        return $this->serializerRegistry->getSerializer('github', $request->headers->get('X-Github-Event'));
    }
}
