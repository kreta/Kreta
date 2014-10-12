<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IssueController extends Controller
{
   public function viewAction($id)
   {
       $issue = $this->get('kreta_core.repository_issue')->find($id);
       if(!$issue) {
           throw new NotFoundHttpException();
       }

       return $this->render('KretaWebBundle:Issue:view.html.twig', array('issue' => $issue));
   }
}
