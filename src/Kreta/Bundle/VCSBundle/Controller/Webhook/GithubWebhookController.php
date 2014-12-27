<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\VCSBundle\Controller\Webhook;

class GithubWebhookController extends AbstractWebhookController
{
    /**
     * {@inheritdoc}
     */
    public function getWebhookStrategy()
    {
        return $this->get('kreta_vcs.webhook_strategy.github');
    }
}
