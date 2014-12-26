<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\WebhookStrategy;

use Kreta\Component\VCS\Event\NewCommitsEvent;
use Symfony\Component\HttpFoundation\Request;

class GithubWebhookStrategy extends AbstractWebhookStrategy
{

    /**
     * {@inheritdoc}
     */
    public function handleWebhook(Request $request)
    {
        //Security should be checked
        $event = $request->headers->get('X-Github-Event');
        if ('push' === $event) {
            $this->handleCommit(json_decode($request->getContent(), true));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function handleCommit($json)
    {
        $commits = $this->resolver->getCommits($json);
        foreach ($commits as $commit) {
            $this->manager->persist($commit);
        }
        $this->manager->flush();
        $this->eventDispatcher->dispatch('k', new NewCommitsEvent($commits));
    }

    /**
     * {@inheritdoc}
     */
    protected function handlePullRequest($event)
    {
        return $this->resolver->getPullRequest($event);
    }
}
