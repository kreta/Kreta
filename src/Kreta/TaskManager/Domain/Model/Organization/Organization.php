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

declare(strict_types=1);

namespace Kreta\TaskManager\Domain\Model\Organization;

class Organization
{
    private $id;

    private $name;

    public function __construct(OrganizationId $id, string $name, OrganizationSlug $slug)
    {
        if($name === '') {
            throw new OrganizationNameEmptyException();
        }

        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
    }

    public function id() : OrganizationId
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->id->id();
    }

    public function name() : string
    {
        return $this->name;
    }

    public function slug() : OrganizationSlug
    {
        return $this->slug;
    }
}
