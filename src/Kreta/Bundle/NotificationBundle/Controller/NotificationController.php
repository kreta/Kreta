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

namespace Kreta\Bundle\NotificationBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class NotificationController.
 */
class NotificationController extends Controller
{
    /**
     * Returns all notifications, it admits date, title, type and read filters, sort limit and offset.
     *
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="q", requirements="(.*)", strict=true, nullable=true, description="Title's filter")
     * @QueryParam(name="project", requirements="(.*)", strict=true, nullable=true, description="Project filter")
     * @QueryParam(name="type", requirements="(.*)", strict=true, nullable=true, description="Type's filter")
     * @QueryParam(name="read", requirements="(true|false)", nullable=true, description="Is read filter")
     * @QueryParam(name="date", requirements="(.*)", strict=true, nullable=true, description="Date filter")
     * @QueryParam(name="sort", requirements="(title|date|type|read)", default="date", description="Sort")
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of comments to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(resource=true, statusCodes = {200})
     * @View(statusCode=200, serializerGroups={"notificationList"})
     *
     * @return \Kreta\Component\Notification\Model\Interfaces\NotificationInterface[]
     */
    public function getNotificationsAction(ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_notification.repository.notification')->findByUser(
            $this->getUser(),
            [
                'title' => $paramFetcher->get('q'),
                'p.id'  => $paramFetcher->get('project'),
                'type'  => $paramFetcher->get('type'),
                'read'  => $paramFetcher->get('read') ? true : false,
                'date'  => !$paramFetcher->get('date') ?: new \DateTime($paramFetcher->get('date')),
            ],
            [$paramFetcher->get('sort') => 'ASC'],
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
    }

    /**
     * Updated the notification read status.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        The request
     * @param string                                    $notificationId The notification id
     *
     * @ApiDoc(statusCodes={200, 400, 403, 404})
     * @View(statusCode=200, serializerGroups={"notification"})
     *
     * @return \Kreta\Component\Notification\Model\Interfaces\NotificationInterface
     */
    public function patchNotificationsAction(Request $request, $notificationId)
    {
        $notification = $this->get('kreta_notification.repository.notification')
            ->findOneByUser($notificationId, $this->getUser());

        return $this->get('kreta_notification.form_handler.notification')->processForm(
            $request, $notification, ['method' => 'PATCH']
        );
    }
}
