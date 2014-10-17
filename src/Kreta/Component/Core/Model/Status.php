<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Model;

use Kreta\Component\Core\Model\Abstracts\AbstractModel;
use Kreta\Component\Core\Model\Interfaces\StatusInterface;

/**
 * Class Status.
 *
 * @package Kreta\Component\Core\Model
 */
class Status extends AbstractModel implements StatusInterface
{
    /**
     * The description.
     *
     * @var string
     */
    protected $description;

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Returns status description
     *
     * @return string
     */
    public function __toString()
    {
        return $this->description;
    }


}
