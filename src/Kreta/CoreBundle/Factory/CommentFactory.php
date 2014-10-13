<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\CoreBundle\Factory;

use Kreta\CoreBundle\Model\Comment;
use Kreta\CoreBundle\Factory\Abstracts\AbstractFactory;

/**
 * Class CommentFactory.
 *
 * @package Kreta\CoreBundle\Factory
 */
class CommentFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new Comment();
    }
}
