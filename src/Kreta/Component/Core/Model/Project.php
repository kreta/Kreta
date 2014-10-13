<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\CoreBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Kreta\CoreBundle\Model\Abstracts\AbstractModel;
use Kreta\CoreBundle\Model\Interfaces\ProjectInterface;
use Kreta\CoreBundle\Model\Interfaces\UserInterface;

/**
 * Class Project.
 *
 * @package Kreta\CoreBundle\Model
 */
class Project extends AbstractModel implements ProjectInterface
{
    /**
     * The name.
     *
     * @var string
     */
    protected $name;

    /**
     * Array that contains users.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $participants;

    /**
     * The short name.
     *
     * @var string
     */
    protected $shortName;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        if ($this->shortName === null) {
            $this->shortName = substr($this->name, 0, 26) . '...';
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * {@inheritdoc}
     */
    public function addParticipant(UserInterface $participant)
    {
        $this->participants[] = $participant;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeParticipant(UserInterface $participant)
    {
        $this->participants->removeElement($participant);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * {@inheritdoc}
     */
    public function setShortName($shortName)
    {
        if (strlen($shortName) > 26) {
            $this->shortName = substr($shortName, 0, 26) . '...';

            return $this;
        }

        $this->shortName = $shortName;

        return $this;
    }
}
