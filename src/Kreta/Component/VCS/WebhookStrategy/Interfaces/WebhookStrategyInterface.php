<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\WebhookStrategy\Interfaces;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class WebhookStrategyInterface
 *
 * @package Kreta\Component\VCS\WebhookStrategy\Interfaces
 */
interface WebhookStrategyInterface
{
    /**
     * Decides with parser should be used for the given request and returns it
     *
     * @param Request $request The request done by the webhook
     *
     * @return \Kreta\Component\VCS\Serializer\Interfaces\SerializerInterface
     */
    public function getSerializer(Request $request);
} 
