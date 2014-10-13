<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\CoreBundle\Model\Interfaces;

/**
 * Interface Project.
 *
 * @package Kreta\CoreBundle\Model\Interfaces
 */
interface ProjectInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

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
     * Gets participants.
     *
     * @return \Kreta\CoreBundle\Model\Interfaces\UserInterface[]
     */
    public function getParticipants();

    /**
     * Adds participant.
     *
     * @param \Kreta\CoreBundle\Model\Interfaces\UserInterface $participant The user object
     *
     * @return $this self Object
     */
    public function addParticipant(UserInterface $participant);

    /**
     * Removes participant.
     *
     * @param \Kreta\CoreBundle\Model\Interfaces\UserInterface $participant The user object
     *
     * @return $this self Object
     */
    public function removeParticipant(UserInterface $participant);

    /**
     * Gets short name.
     *
     * @return string
     */
    public function getShortName();

    /**
     * Sets short name.
     *
     * @param string $shortName The short name
     *
     * @return $this self Object
     */
    public function setShortName($shortName);
}
