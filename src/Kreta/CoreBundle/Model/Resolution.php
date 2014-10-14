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

use Kreta\CoreBundle\Model\Abstracts\AbstractModel;
use Kreta\CoreBundle\Model\Interfaces\ResolutionInterface;

/**
 * Class Resolution.
 *
 * @package Kreta\CoreBundle\Model
 */
class Resolution extends AbstractModel implements ResolutionInterface
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
}
