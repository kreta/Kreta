<?php
/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Serializer\Github;

use Kreta\Component\VCS\Factory\CommitFactory;
use Kreta\Component\VCS\Serializer\Interfaces\SerializerInterface;

class CommitSerializer implements SerializerInterface {

    protected $factory;

    public function __construct(CommitFactory $factory)
    {
        $this->factory = $factory;
    }

    public function deserialize($json)
    {
        $jsonCommit = $json['head_commit'];

        $commit = $this->factory->create($jsonCommit['id'], $jsonCommit['message'], $json['repository']['full_name'],
            $jsonCommit['author']['username'], 'github', $jsonCommit['url']);

        return $commit;
    }
}
