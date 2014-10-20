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

class IssueComponentController extends Controller
{
    public function userAction()
    {
        $issues = $this->get('kreta_core.repository_issue')->findByAssignee(
            $this->getUser(),
            array(),
            array('status' => 'ASC', 'priority' => 'DESC')
        );

        return $this->render('KretaWebBundle:Component/Issue:user.html.twig',
            array('issues' => $issues));
    }
}
