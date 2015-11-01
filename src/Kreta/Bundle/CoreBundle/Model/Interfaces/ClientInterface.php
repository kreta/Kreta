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

namespace Kreta\Bundle\CoreBundle\Model\Interfaces;

use FOS\OAuthServerBundle\Model\ClientInterface as BaseClientInterface;

/**
 * Interface ClientInterface.
 */
interface ClientInterface extends BaseClientInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();
}
