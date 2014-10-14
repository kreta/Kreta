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
use Kreta\Component\Core\Model\Interfaces\LabelInterface;
use Kreta\Component\Core\Util\Slugger;

/**
 * Class Label.
 *
 * @package Kreta\Component\Core\Model
 */
class Label extends AbstractModel implements LabelInterface
{
    /**
     * The name.
     *
     * @var string
     */
    protected $name;

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
        $this->name = Slugger::slugify($name);

        return $this;
    }
}
