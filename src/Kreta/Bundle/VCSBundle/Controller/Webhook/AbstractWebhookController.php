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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractWebhookController
 *
 * Responsible for exposing the entrance point for webhooks. Each provider should have one controller with
 * getWebhookStrategy() implemented.
 *
 * @package Kreta\Bundle\VCSBundle\Controller\Webhook
 */
abstract class AbstractWebhookController extends Controller
{
    /**
     * Exposes the action that will be registered as a webhook in the VCS provider.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function webhookAction(Request $request)
    {
        $this->getWebhookStrategy()->handleWebhook($request);
        return new Response();
    }

    /**
     * Gets webhook strategy to be used in this case. Each VCS should have one
     *
     * @return /Kreta/Component/VCS/WebhookStrategy/AbstractWebhookController
     */
    abstract public function getWebhookStrategy();

} 
