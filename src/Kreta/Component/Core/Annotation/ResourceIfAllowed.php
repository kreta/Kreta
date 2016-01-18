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

namespace Kreta\Component\Core\Annotation;

/**
 * Class ResourceIfAllowed.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
