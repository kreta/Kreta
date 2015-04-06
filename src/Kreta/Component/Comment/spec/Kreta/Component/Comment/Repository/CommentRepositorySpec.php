<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Comment\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Comment\Model\Interfaces\CommentInterface;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Prophecy\Argument;

/**
 * Class CommentRepositorySpec.
 *
 * @package spec\Kreta\Component\Comment\Repository
 */
class CommentRepositorySpec extends BaseEntityRepository
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Comment\Repository\CommentRepository');
    }

    function it_extends_kretas_entity_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\EntityRepository');
    }

    function it_finds_by_issue(
        IssueInterface $issue,
        CommentInterface $comment,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Func $func,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $createdAt = new \DateTime();
        $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addBetweenCriteriaSpec($queryBuilder, $expr, $func, ['createdAt' => $createdAt]);
        $this->addCriteriaSpec($queryBuilder, $expr, ['wb.email' => 'user@kreta.com'], $comparison);
        $this->addCriteriaSpec($queryBuilder, $expr, ['issue' => $issue], $comparison);
        $this->orderBySpec($queryBuilder, ['createdAt' => 'ASC']);
        $queryBuilder->setMaxResults(1)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setFirstResult(1)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$comment]);

        $this->findByIssue($issue, $createdAt, 'user@kreta.com', 1, 1)->shouldReturn([$comment]);
    }

    function it_finds_by_user(
        UserInterface $user,
        CommentInterface $comment,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['id' => 'comment-id'], $comparison);
        $this->addCriteriaSpec($queryBuilder, $expr, ['writtenBy' => $user], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getSingleResult()->shouldBeCalled()->willReturn([$comment]);

        $this->findByUser('comment-id', $user)->shouldReturn([$comment]);
    }

    protected function getQueryBuilderSpec(EntityManager $manager, QueryBuilder $queryBuilder)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('c')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->addSelect(['i', 'wb'])
            ->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'c', null)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('c.issue', 'i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('c.writtenBy', 'wb')->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function getAlias()
    {
        return 'c';
    }
}
