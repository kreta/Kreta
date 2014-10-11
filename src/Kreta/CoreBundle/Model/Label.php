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
use Kreta\CoreBundle\Model\Interfaces\LabelInterface;
use Kreta\CoreBundle\Util\Util;

/**
 * Class Label.
 *
 * @package Kreta\CoreBundle\Model
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
        $this->name = Util::generateSlug($name);

        return $this;
    }
}
