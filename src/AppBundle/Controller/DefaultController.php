<?php

namespace Kreta\AppBundle\Controller;

use Kreta\TaskManager\Domain\Model\Organization\Member;
use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\User\UserId;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $organization = $this->getDoctrine()->getRepository(Organization::class)->findOneBy([
            'name' => 'Organization name',
        ]);

        dump($organization->owners(), $organization->members());
        die;

        return $this->render('default/index.html.twig', [
            'pages' => $pages,
        ]);
    }
}
