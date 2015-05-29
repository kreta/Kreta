<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Model;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Kreta\Bundle\CoreBundle\Model\Interfaces\ClientInterface;

/**
 * Class Client.
 *
 * @package Kreta\Bundle\CoreBundle\Model
 */
class Client extends BaseClient implements ClientInterface
{
}
