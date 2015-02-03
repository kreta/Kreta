<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Model;

use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;
use Kreta\Bundle\CoreBundle\Model\Interfaces\AccessTokenInterface;

/**
 * Class AccessToken.
 *
 * @package Kreta\Bundle\CoreBundle\Model
 */
class AccessToken extends BaseAccessToken implements AccessTokenInterface
{
}
