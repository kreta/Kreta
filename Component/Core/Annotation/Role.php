<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Annotation;

/**
 * Class Role.
 *
 * @package Kreta\Component\Core\Annotation
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
