<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Util;

/**
 * Class CamelCaser.
 *
 * @package Kreta\Component\Core\Util
 */
class CamelCaser
{
    /**
     * This function is copied from "Underscore To Camel Case"
     * http://www.phpro.org/examples/Underscore-To-Camel-Case.html
     *
     * Converts strings with underscores into CamelCase.
     *
     * @param string  $string        The string to convert
     * @param boolean $firstCharCaps camelCase or CamelCase
     *
     * @return string
     */
    public static function underscoreToCamelCase($string, $firstCharCaps = false)
    {
        if ($firstCharCaps) {
            $string[0] = strtoupper($string[0]);
        }
        $func = create_function('$c', 'return strtoupper($c[1]);');

        return preg_replace_callback('/_([a-z])/', $func, $string);
    }
}
