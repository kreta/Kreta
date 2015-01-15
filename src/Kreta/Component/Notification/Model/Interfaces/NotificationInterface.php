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
 * Class NotificationInterface.
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
     * Gets the date.
     *
     * @return \Datetime
     */
    public function getDate();

    /**
     * Sets the date.
     *
     * @param \Datetime $date The date
     *
     * @return $this self Object
     */
    public function setDate(\Datetime $date);

    /**
     * Gets the description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Sets the description.
     *
     * @param string $description The description
     *
     * @return $this self Object
     */
    public function setDescription($description);

    /**
     * Gets the project.
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    public function getProject();

    /**
     * Sets project.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project The project
     *
     * @return $this self Object
     */
    public function setProject(ProjectInterface $project);

    /**
     * Gets if notification has been read.
     *
     * @return boolean
     */
    public function isRead();

    /**
     * Sets read.
     *
     * @param boolean $read Boolean that checks if the notification has been read or not
     *
     * @return $this self Object
     */
    public function setRead($read);

    /**
     * Gets relative URL linking the notification in the API.
     *
     * @return string
     */
    public function getResourceUrl();

    /**
     * Sets relative URL linking the notification in the API.
     *
     * @param string $url The Url pointing the notified resource in the website
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
     * @param string $title The title
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
     * @param string $type The type
     *
     * @return $this self Object
     */
    public function setType($type);

    /**
     * Gets user.
     *
     * @return \Kreta\Component\User\Model\Interfaces\UserInterface
     */
    public function getUser();

    /**
     * Sets user.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user The user
     *
     * @return $this self Object
     */
    public function setUser(UserInterface $user);

    /**
     * Gets relative URL linking the notification in the website.
     *
     * @return string
     */
    public function getWebUrl();

    /**
     * Sets relative URL linking the notification in the website.
     *
     * @param string $url The Url pointing the notified resource in the website
     *
     * @return $this self Object
     */
    public function setWebUrl($url);
}
