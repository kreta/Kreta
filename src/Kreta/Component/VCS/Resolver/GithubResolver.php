<?php
/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Resolver;

use Kreta\Component\VCS\Factory\CommitFactory;
use Kreta\Component\VCS\Resolver\Interfaces\ResolverInterface;

class GithubResolver implements ResolverInterface {

    protected $factory;

    public function __construct(/*CommitFactory $factory*/)
    {
        //$this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function getPullRequest($json)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommits($json)
    {
        $commits = [];
        $jsonCommits = $json['commits'];

        /*foreach($jsonCommits as $json) {
            $commit = $this->factory->create($json['id'], $json['message'], $json['repository']['full_name'],
                $json['author']['username'], 'github', $json['url']);
            $commits[] = $commit;
        }*/

        return $commits;
    }
}
