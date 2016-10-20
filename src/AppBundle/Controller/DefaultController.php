<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kreta\AppBundle\Controller;

use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMember;
use Kreta\TaskManager\Domain\Model\User\UserId;
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
        $organization = $this->getDoctrine()->getRepository(Organization::class)->findOneBy([
            'name' => 'Organization name',
        ]);

        dump(
            $organization->owners(),
            $organization->members(),
            $organization->isOwner(UserId::generate('04593fee-7e7a-40fa-8d1a-da42a97e40e5')),
            $organization->isOrganizationMember(UserId::generate('04593fee-7e7a-40fa-8d1a-da42a97e40e5')),
            $organization->owners()->contains(
                new OrganizationMember(
                    MemberId::generate(),
                    UserId::generate('04593fee-7e7a-40fa-8d1a-da42a97e40e5'),
                    $organization
                )

            )
        );
        die;

        return $this->render('default/index.html.twig', [
            'pages' => $pages,
        ]);
    }
}
