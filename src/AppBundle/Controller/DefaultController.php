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
        $organization = $this->getDoctrine()->getRepository(Organization::class)->find(
            '18f88f5e-7e87-4035-b134-299165a0ddafd'
        );

        if (null === $organization) {
            throw new NotFoundHttpException(
                'METE EL ID DE LA ORGANIZATION QUE SE TE HA CREADO EN LA DB EN EL ACTION DEL CONTROLLER:' .
                'src/AppBundle/Controller/DefaultController'
            );
        }

        $organization->addMember(
            new Member(
                MemberId::generate(
                    UserId::generate(),
                    $organization->id()
                )
            )
        );
        $this->getDoctrine()->getManager()->persist($organization);
        $this->getDoctrine()->getManager()->flush();


        dump($organization->members());
        die;

        return $this->render('default/index.html.twig', [
            'pages' => $pages,
        ]);
    }
}
