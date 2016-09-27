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

namespace Kreta\AppBundle\Resolver;

use GraphQL\Tests\StarWarsData;
use Overblog\GraphQLBundle\Resolver\TypeResolver;

class CharacterResolver
{
    private $typeResolver;

    public function __construct(TypeResolver $typeResolver)
    {
        $this->typeResolver = $typeResolver;
    }

    public function resolveType($data)
    {
        $humanType = $this->typeResolver->resolve('Human');
        $droidType = $this->typeResolver->resolve('Droid');

        $humans = StarWarsData::humans();
        $droids = StarWarsData::droids();
        if (isset($humans[$data['id']])) {
            return $humanType;
        }
        if (isset($droids[$data['id']])) {
            return $droidType;
        }

        return null;
    }

    public function resolveFriends($character) : array
    {
        return StarWarsData::getFriends($character);
    }

    public function resolveHero($args)
    {
        return StarWarsData::getHero(isset($args['episode']) ? $args['episode'] : null);
    }

    public function resolveHuman($args)
    {
        $humans = StarWarsData::humans();

        return isset($humans[$args['id']]) ? $humans[$args['id']] : null;
    }

    public function resolveDroid($args)
    {
        $droids = StarWarsData::droids();

        return isset($droids[$args['id']]) ? $droids[$args['id']] : null;
    }
}
