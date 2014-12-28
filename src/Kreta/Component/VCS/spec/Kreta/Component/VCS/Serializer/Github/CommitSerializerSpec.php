<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\Serializer\Github;

use Kreta\Component\VCS\Factory\CommitFactory;
use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use PhpSpec\ObjectBehavior;

class CommitSerializerSpec extends ObjectBehavior
{
    function let(CommitFactory $factory)
    {
        $this->beConstructedWith($factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Serializer\Github\CommitSerializer');
    }

    function it_deserializes_commit_info(CommitFactory $factory, CommitInterface $commit)
    {
        $json = json_encode(
            [
                'head_commit' => [
                    'id' => '11231',
                    'message' => 'Test commit',
                    'author' => ['username' => 'gorkalaucirica'],
                    'url' => 'http://github.com/kreta-io/kreta'
                ],
                'repository' => ['full_name' => 'kreta-io/kreta']
            ]
        );

        $factory->create('11231', 'Test commit', 'kreta-io/kreta', 'gorkalaucirica', 'github',
            'http://github.com/kreta-io/kreta')->shouldBeCalled()->willReturn($commit);

        $this->deserialize($json)->shouldReturn($commit);
    }
} 
