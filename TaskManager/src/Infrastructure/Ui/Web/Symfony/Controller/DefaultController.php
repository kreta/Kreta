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

namespace Kreta\TaskManager\Infrastructure\Ui\Web\Symfony\Controller;

use Doctrine\ORM\EntityManager;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMember;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberId;
use Kreta\TaskManager\Domain\Model\User\UserId;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class DefaultController
{
    private $templating;
    private $manager;

    public function __construct(EngineInterface $templating, EntityManager $manager)
    {
        $this->templating = $templating;
        $this->manager = $manager;
    }

    public function indexAction()
    {
        $organization = $this->manager->getRepository(Organization::class)->findOneBy([
            'name' => 'Organization name',
        ]);

        dump(
            $organization->owners(),
            $organization->organizationMembers(),
            $organization->isOwner(UserId::generate('ffede864-efef-47ab-b6bb-8c24badae2be')),
            $organization->isOrganizationMember(UserId::generate('ffede864-efef-47ab-b6bb-8c24badae2be')),
            $organization->addOwner(UserId::generate('ffede864-efef-47ab-b6bb-8c24badae2be')),
            $organization->isOwner(UserId::generate('ffede864-efef-47ab-b6bb-8c24badae2be')),
            $organization->owners()->contains(
                new OrganizationMember(
                    OrganizationMemberId::generate(),
                    UserId::generate('ffede864-efef-47ab-b6bb-8c24badae2be'),
                    $organization
                )

            )
        );

        return new Response(
            $this->templating->render('default/index.html.twig')
        );
    }
}
