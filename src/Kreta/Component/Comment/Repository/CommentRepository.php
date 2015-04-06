<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Comment\Repository;

use Kreta\Component\Core\Repository\EntityRepository;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class CommentRepository.
 *
 * @package Kreta\Component\Comment\Repository
 */
class CommentRepository extends EntityRepository
{
    /**
     * Finds all the comments of issue given ordering by createdAt.
     * The result can be more strict adding user and createAt criteria.
     * Can do limit and offset.
     *
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface $issue     The issue
     * @param \DateTime                                              $createdAt The created at
     * @param string                                                 $writtenBy The email of user
     * @param int                                                    $limit     The limit
     * @param int                                                    $offset    The offset
     *
     * @return \Kreta\Component\Comment\Model\Interfaces\CommentInterface[]
     */
    public function findByIssue(
        IssueInterface $issue,
        \DateTime $createdAt = null,
        $writtenBy = null,
        $limit = null,
        $offset = null
    )
    {
        $queryBuilder = $this->getQueryBuilder();
        if ($createdAt instanceof \DateTime) {
            $this->addCriteria($queryBuilder, ['between' => ['createdAt' => $createdAt]]);
        }
        if ($writtenBy !== null) {
            $this->addCriteria($queryBuilder, ['wb.email' => $writtenBy]);
        }
        $this->addCriteria($queryBuilder, ['issue' => $issue]);
        $this->orderBy($queryBuilder, ['createdAt' => 'ASC']);

        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }
        if ($offset) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Finds the comments of given id if the user given is its writer.
     *
     * @param string                                               $commentId The comment id
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user      The user
     *
     * @return \Kreta\Component\Comment\Model\Interfaces\CommentInterface
     */
    public function findByUser($commentId, UserInterface $user)
    {
        return $this->findOneBy(['id' => $commentId, 'writtenBy' => $user], false);
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->addSelect(['i', 'wb'])
            ->join('c.issue', 'i')
            ->join('c.writtenBy', 'wb');
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'c';
    }
}
