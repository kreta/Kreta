<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Project\Repository;

use Kreta\Component\Core\Repository\EntityRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class ProjectRepository.
 *
 * @package Kreta\Component\Project\Repository
 */
class ProjectRepository extends EntityRepository
{
    /**
     * Finds all the projects where user given is participant.
     * Can do ordering, limit and offset.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user    The user
     * @param string[]                                             $sorting Array which contains the sorting as key/val
     * @param int                                                  $limit   The limit
     * @param int                                                  $offset  The offset
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface[]
     */
    public function findByParticipant(UserInterface $user, array $sorting = [], $limit = null, $offset = null)
    {
        return $this->findBy(['par.user' => $user], $sorting, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->addSelect(['img', 'i', 'par', 'w'])
            ->leftJoin('p.image', 'img')
            ->leftJoin('p.issues', 'i')
            ->join('p.participants', 'par')
            ->join('p.workflow', 'w');
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'p';
    }
}
