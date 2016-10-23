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
use Kreta\SharedKernel\Application\CommandBus;
use Kreta\TaskManager\Application\Organization\AddOrganizationMemberToOrganizationCommand;
use Kreta\TaskManager\Application\Organization\CreateOrganizationCommand;
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
    private $commandBus;

    public function __construct(EngineInterface $templating, EntityManager $manager, CommandBus $commandBus)
    {
        $this->templating = $templating;
        $this->manager = $manager;
        $this->commandBus = $commandBus;
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

        $this->commandBus->handle(
            new CreateOrganizationCommand(
                '001976ca-b9fe-4e92-bc8e-953ad3db1d02',
                'New organization name'
            )
        );

        $this->commandBus->handle(
            new AddOrganizationMemberToOrganizationCommand(
                'lalalalauser-id',
                '0898d47f-bdec-4ae7-bb70-bdd0fc7c432a',
                '001976ca-b9fe-4e92-bc8e-953ad3db1d02'
            )
        );

        return new Response(
            $this->templating->render('default/index.html.twig')
        );
    }
}
