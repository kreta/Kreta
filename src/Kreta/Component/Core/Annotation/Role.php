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
 * Class Role.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * @Annotation
 */
class Role
{
    /**
     * The roles.
     *
     * @var array
     */
    protected $roles;

    /**
     * Constructor.
     *
     * @param array $data Array that contains roles value
     */
    public function __construct(array $data)
    {
        $this->roles = [];
        if (array_key_exists('value', $data)) {
            if (is_array($data['value'])) {
                $this->roles = $data['value'];
            } else {
                $values = explode(',', $data['value']);
                foreach ($values as $value) {
                    $this->roles[] = trim($value);
                }
            }
        }
    }

    /**
     * Gets the roles.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
