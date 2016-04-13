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

namespace Kreta\Component\Organization\Repository;

use Kreta\Component\Core\Repository\EntityRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Organization repository.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationRepository extends EntityRepository
{
    /**
     * Finds all the organizations where user given is participant.
     * Can do ordering, limit and offset.
     *
     * @param UserInterface $user    The user
     * @param string[]      $sorting Array which contains the sorting as key/val
     * @param int           $limit   The limit
     * @param int           $offset  The offset
     *
     * @return \Kreta\Component\Organization\Model\Interfaces\OrganizationInterface[]
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
            ->addSelect(['img', 'p'])
            ->leftJoin('o.image', 'img')
            ->join('o.participants', 'par')
            ->leftJoin('o.projects', 'p');
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'o';
    }
}
