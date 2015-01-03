<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\Controller\Component;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class VCSComponentController
 *
 * @package Kreta\Bundle\WebBundle\Controller\Component
 */
class VCSComponentController extends Controller
{
    /**
     * User action.
     *
     * @return array
     */
    public function issueAction($issueId)
    {
        $commits = $this->get('kreta_vcs.repository.commit')->findByIssue($issueId);
        $branches = $this->get('kreta_vcs.repository.branch')->findByIssue($issueId);
        $repositories = $this->get('kreta_vcs.repository.repository')->findByIssue($issueId);

        return $this->render('KretaWebBundle:Component/VCS:issue.html.twig', [
            'commits' => $commits, 'branches' => $branches, 'repositories' => $repositories
        ]);
    }

}
