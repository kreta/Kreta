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
 * Class Slugger.
 *
 * @package Kreta\Component\Core\Util
 */
class Slugger
{
    /**
     * This function is copied from "The perfect PHP clean URL generator"
     * http://cubiq.org/the-perfect-php-clean-url-generator
     *
     * Creates slug with string and delimiter given.
     *
     * @param string $string    The string
     * @param string $delimiter Words delimiter, by default '-'
     *
     * @return string
     */
    public static function slugify($string, $delimiter = '-')
    {
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $slug = preg_replace('/[^a-zA-Z0-9\/_|+ -]/', '', $slug);
        $slug = strtolower(trim($slug, $delimiter));
        $slug = preg_replace('/[\/_|+ -]+/', $delimiter, $slug);

        return $slug;
    }
}
