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

    public function __construct(OrganizationId $id, OrganizationName $name, OrganizationSlug $slug)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
    }

    public function id() : OrganizationId
    {
        return $this->id;
    }

    public function name() : OrganizationName
    {
        return $this->name;
    }

    public function slug() : OrganizationSlug
    {
        return $this->slug;
    }

    public function __toString() : string
    {
        return (string) $this->id->id();
    }
}
