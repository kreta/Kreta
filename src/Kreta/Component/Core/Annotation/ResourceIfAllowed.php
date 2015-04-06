<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Annotation;

/**
 * Class ResourceIfAllowed.
 *
 * @package Kreta\Component\Core\Annotation
 *
 * @Annotation
 */
class ResourceIfAllowed
{
    /**
     * The grant.
     *
     * @var string
     */
    protected $grant;

    /**
     * Constructor.
     *
     * @param array $data Array that contains grant value
     */
    public function __construct(array $data)
    {
        $this->grant = 'view';
        if (array_key_exists('value', $data)) {
            $this->grant = $data['value'];
        }
    }

    /**
     * Gets the grant.
     *
     * @return string
     */
    public function getGrant()
    {
        return $this->grant;
    }
}
