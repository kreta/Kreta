<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\Model\Interfaces;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class NotificationInterface
 *
 * @package Kreta\Component\Notification\Model\Interfaces
 */
interface NotificationInterface
{
    /**
     * Gets the id.
     *
     * @return string
     */
    public function getId();

    /**
     * Sets the id.
     *
     * @param string $id The id.
     *
     * @return $this self Object
     */
    public function setId($id);

    /**
     * Gets the date.
     *
     * @return \Datetime The date.
     */
    public function getDate();

    /**
     * Sets the datetime.
     *
     * @param \Datetime $date
     *
     * @return $this self Object
     */
    public function setDate(\Datetime $date);

    /**
     * Gets the description.
     *
     * @return string The description.
     */
    public function getDescription();

    /**
     * Sets the description.
     *
     * @param $description
     *
     * @return $this self Object
     */
    public function setDescription($description);

    /**
     * Gets the project.
     *
     * @return ProjectInterface
     */
    public function getProject();

    /**
     * @param ProjectInterface $project
     *
     * @return $this self Object
     */
    public function setProject(ProjectInterface $project);

    /**
     * Gets if notification has been read.
     *
     * @return bool
     */
    public function isRead();

    /**
     * Sets read.
     *
     * @param bool $read
     *
     * @return $this self Object
     */
    public function setRead($read);

    /**
     * Gets relative URL linking the notification in the API.
     *
     * @return string The Url pointing the notified resource in the website.
     */
    public function getResourceUrl();

    /**
     * Sets relative URL linking the notification in the API.
     *
     * @param string $url The Url pointing the notified resource in the website.
     *
     * @return $this self Object
     */
    public function setResourceUrl($url);

    /**
     * Gets title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Sets title.
     *
     * @param string $title
     *
     * @return $this self Object
     */
    public function setTitle($title);

    /**
     * Gets type.
     *
     * @return string
     */
    public function getType();

    /**
     * Sets type.
     *
     * @param string $type
     *
     * @return $this self Object
     */
    public function setType($type);

    /**
     * Gets user.
     *
     * @return UserInterface
     */
    public function getUser();

    /**
     * Sets user.
     *
     * @param UserInterface $user
     *
     * @return $this self Object
     */
    public function setUser(UserInterface $user);

    /**
     * Gets relative URL linking the notification in the website.
     *
     * @return string The Url pointing the notified resource in the website.
     */
    public function getWebUrl();

    /**
     * Sets relative URL linking the notification in the website.
     *
     * @param string $url The Url pointing the notified resource in the website.
     *
     * @return $this self Object
     */
    public function setWebUrl($url);
}
