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

namespace Kreta\Component\Project\Repository;

use Kreta\Component\Core\Repository\EntityRepository;
use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class ProjectRepository.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ProjectRepository extends EntityRepository
{
    /**
     * Finds all the projects where user given is participant.
     * Also supports organization criteria.
     *
     * Can do ordering, limit and offset.
     *
     * @param UserInterface         $user         The user
     * @param OrganizationInterface $organization The organization
     * @param string[]              $sorting      Array which contains the sorting as key/val
     * @param int                   $limit        The limit
     * @param int                   $offset       The offset
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface[]
     */
    public function findByParticipant(
        UserInterface $user,
        OrganizationInterface $organization = null,
        array $sorting = [],
        $limit = null,
        $offset = null
    ) {
        $criteria = ['par.user' => $user];
        if ($organization instanceof OrganizationInterface) {
            $criteria = array_merge($criteria, ['organization' => $organization]);
        }

        return $this->findBy($criteria, $sorting, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->addSelect(['img', 'i', 'o', 'w'])
            ->leftJoin('p.image', 'img')
            ->leftJoin('p.issues', 'i')
            ->join('p.participants', 'par')
            ->join('p.organization', 'o')
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
