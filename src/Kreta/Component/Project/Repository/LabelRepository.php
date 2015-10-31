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
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;

/**
 * Class LabelRepository.
 *
 * @package Kreta\Component\Project\Repository
 */
class LabelRepository extends EntityRepository
{
    /**
     * Finds all the labels of project given.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project  The project
     * @param null|int                                                   $limit    The limit
     * @param null|int                                                   $offset   The offset
     * @param null|string                                                $criteria The filter criteria
     *
     * @return \Kreta\Component\Project\Model\Interfaces\LabelInterface[]
     */
    public function findByProject(ProjectInterface $project, $limit = null, $offset = null, $criteria = null)
    {
        return $this->findBy(
            ['project' => $project, 'like' => ['name' => $criteria]], ['name' => 'ASC'], $limit, $offset
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->addSelect(['p'])
            ->join('l.project', 'p');
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'l';
    }
}
