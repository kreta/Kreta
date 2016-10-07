<?php

declare(strict_types=1);

namespace Kreta\TaskManager\Domain\Model\Organization;

class OrganizationNameEmptyException extends \Exception
{
    public function __construct()
    {
        parent::__construct();
        $this->message = 'Organization name must not be empty';
    }
}
