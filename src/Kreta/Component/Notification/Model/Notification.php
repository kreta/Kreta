<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\Model;

use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Kreta\Component\Notification\Model\Interfaces\NotificationInterface;

class Notification implements NotificationInterface
{
    protected $id;

    protected $date;

    protected $description;

    protected $project;

    protected $read;

    protected $title;

    protected $user;

    /**
     * @{@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @{@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @{@inheritdoc}
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @{@inheritdoc}
     */
    public function setDate(\Datetime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @{@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @{@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @{@inheritdoc}
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @{@inheritdoc}
     */
    public function setProject(ProjectInterface $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @{@inheritdoc}
     */
    public function isRead()
    {
        return $this->read;
    }

    /**
     * @{@inheritdoc}
     */
    public function setRead($read)
    {
        $this->read = $read;

        return $this;
    }

    /**
     * @{@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @{@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @{@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @{@inheritdoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }
}
