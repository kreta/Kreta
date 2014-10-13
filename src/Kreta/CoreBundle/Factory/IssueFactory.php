<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\CoreBundle\Factory;

use Kreta\CoreBundle\Model\Issue;
use Kreta\CoreBundle\Factory\Abstracts\AbstractFactory;

/**
 * Class IssueFactory.
 *
 * @package Kreta\CoreBundle\Factory
 */
class IssueFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new Issue();
    }
}
