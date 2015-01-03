<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Stubs\Repository\Abstracts;

use Kreta\Component\Core\Repository\Abstracts\AbstractRepository;

/**
 * Class AbstractRepositoryStub.
 *
 * @package Kreta\Component\Core\Stubs\Repository\Abstracts
 */
class AbstractRepositoryStub extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'ars';
    }
}
