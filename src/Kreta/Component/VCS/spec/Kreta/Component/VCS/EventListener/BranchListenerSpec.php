<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\EventListener;

use Doctrine\ORM\EntityManager;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\VCS\Event\NewBranchEvent;
use Kreta\Component\VCS\Matcher\BranchMatcher;
use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class BranchListenerSpec.
 *
 * @package spec\Kreta\Component\VCS\EventListener
 */
class BranchListenerSpec extends ObjectBehavior
{
    function let(BranchMatcher $matcher, EntityManager $manager)
    {
        $this->beConstructedWith($matcher, $manager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\EventListener\BranchListener');
    }

    function it_listens_to_new_branch(
        BranchMatcher $matcher,
        EntityManager $manager,
        NewBranchEvent $event,
        BranchInterface $branch,
        IssueInterface $issue
    )
    {
        $event->getBranch()->shouldBeCalled()->willReturn($branch);

        $matcher->getRelatedIssues($branch)->shouldBeCalled()->willReturn([$issue]);
        $branch->setIssuesRelated([$issue])->shouldBeCalled();

        $manager->persist($branch)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->newBranch($event);
    }
}
