<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\Api\ApiCoreBundle\Model;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Kreta\Bundle\Api\ApiCoreBundle\Model\Interfaces\ClientInterface;

/**
 * Class Client.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Model
 */
class Client extends BaseClient implements ClientInterface
{
}
