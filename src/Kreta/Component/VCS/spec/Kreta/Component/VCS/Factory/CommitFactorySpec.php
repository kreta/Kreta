<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\Factory;

use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class CommitFactorySpec.
 *
 * @package spec\Kreta\Component\VCS\Factory
 */
class CommitFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\VCS\Model\Commit');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Factory\CommitFactory');
    }

    function it_creates_a_commit(BranchInterface $branch)
    {
        $this->create('11231', 'Test commit', $branch, 'gorkalaucirica', 'http://github.com/kreta-io/kreta')
            ->shouldReturnAnInstanceOf('Kreta\Component\VCS\Model\Commit');
    }
}
