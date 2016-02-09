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

namespace Kreta\Bundle\CoreBundle\Model;

use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;
use Kreta\Bundle\CoreBundle\Model\Interfaces\RefreshTokenInterface;

/**
 * Class RefreshToken.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class RefreshToken extends BaseRefreshToken implements RefreshTokenInterface
{
}
