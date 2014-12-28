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

use PhpSpec\ObjectBehavior;

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

    function it_creates_a_commit()
    {
        $this->create('11231', 'Test commit', 'kreta-io/kreta', 'gorkalaucirica', 'github',
            'http://github.com/kreta-io/kreta')
            ->shouldReturnAnInstanceOf('Kreta\Component\VCS\Model\Commit');
    }
} 
