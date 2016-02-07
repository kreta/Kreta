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

namespace Kreta\Component\Organization\Model\Interfaces;

use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Organization interface.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
interface OrganizationInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Gets image.
     *
     * @return MediaInterface
     */
    public function getImage();

    /**
     * Sets image.
     *
     * @param MediaInterface $image The image
     *
     * @return $this self Object
     */
    public function setImage(MediaInterface $image);

    /**
     * Gets name.
     *
     * @return string
     */
    public function getName();

    /**
     * Sets name.
     *
     * @param string $name The name
     *
     * @return $this self Object
     */
    public function setName($name);

    /**
     * Gets organization roles.
     *
     * @return ParticipantInterface[]
     */
    public function getParticipants();

    /**
     * Adds organization role.
     *
     * @param ParticipantInterface $participant The organization role
     *
     * @return $this self Object
     */
    public function addParticipant(ParticipantInterface $participant);

    /**
     * Removes organization role.
     *
     * @param ParticipantInterface $participant The organization role
     *
     * @return $this self Object
     */
    public function removeParticipant(ParticipantInterface $participant);

    /**
     * Gets projects.
     *
     * @return ProjectInterface[]
     */
    public function getProjects();

    /**
     * Adds project.
     *
     * @param ProjectInterface $project The project
     *
     * @return $this self Object
     */
    public function addProject(ProjectInterface $project);

    /**
     * Removes project.
     *
     * @param ProjectInterface $project The project
     *
     * @return $this self Object
     */
    public function removeProject(ProjectInterface $project);

    /**
     * Gets role of user given.
     *
     * @param UserInterface $user The user
     *
     * @return string
     */
    public function getUserRole(UserInterface $user);
}
