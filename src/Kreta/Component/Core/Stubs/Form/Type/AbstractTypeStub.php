<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Stubs\Form\Type;

use Kreta\Component\Core\Form\Type\Abstracts\AbstractType;
use Symfony\Component\Form\FormInterface;

/**
 * Class AbstractTypeStub.
 *
 * @package Kreta\Component\Core\Stubs\Form\Type
 */
class AbstractTypeStub extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    protected function createEmptyData(FormInterface $form)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'form_type_name';
    }
}
