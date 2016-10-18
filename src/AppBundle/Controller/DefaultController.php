<?php

namespace Kreta\AppBundle\Controller;

use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $organization = $this->getDoctrine()->getRepository(Organization::class)->find('a0ebb514-0fef-45ca-ac26-ff085087ce7b');

        dump($organization);die;

        return $this->render('default/index.html.twig', [
            'pages' => $pages,
        ]);
    }
}
