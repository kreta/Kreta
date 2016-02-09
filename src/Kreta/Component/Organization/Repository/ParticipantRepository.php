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
use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;

/**
 * Participant repository.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class ParticipantRepository extends EntityRepository
{
    /**
     * Finds all the participants of organization given.
     *
     * @param OrganizationInterface $organization The project
     * @param null|int              $limit        The limit
     * @param null|int              $offset       The offset
     * @param null|string           $criteria     The user email filter criteria
     *
     * @return \Kreta\Component\Organization\Model\Interfaces\ParticipantInterface[]
     */
    public function findByOrganization(
        OrganizationInterface $organization,
        $limit = null,
        $offset = null,
        $criteria = null
    ) {
        return $this->findBy([
            'organization' => $organization,
            'like'         => ['u.email' => $criteria]],
            ['u.email' => 'ASC'],
            $limit,
            $offset
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->addSelect(['o', 'u'])
            ->join('par.organization', 'o')
            ->join('par.user', 'u');
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'par';
    }
}
