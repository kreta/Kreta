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

use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;

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
}
