<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Workflow\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\Abstracts\BaseRepository;
use Prophecy\Argument;

/**
 * Class WorkflowRepositorySpec.
 *
 * @package spec\Kreta\Component\Workflow\Repository
 */
class WorkflowRepositorySpec extends BaseRepository
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Workflow\Repository\WorkflowRepository');
    }

    function it_extends_abstract_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\Abstracts\AbstractRepository');
    }
}
