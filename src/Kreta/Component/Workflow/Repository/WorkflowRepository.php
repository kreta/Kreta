<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Workflow\Repository;

use Kreta\Component\Core\Repository\Abstracts\AbstractRepository;

/**
 * Class WorkflowRepository.
 *
 * @package Kreta\Component\Workflow\Repository
 */
class WorkflowRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'w';
    }
}
