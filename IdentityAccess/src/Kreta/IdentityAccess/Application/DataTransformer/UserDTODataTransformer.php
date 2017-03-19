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

namespace Kreta\IdentityAccess\Application\DataTransformer;

use BenGorUser\User\Application\DataTransformer\UserDTODataTransformer as BaseUserDTODataTransformer;
use Kreta\IdentityAccess\Domain\Model\User\FullName;
use Kreta\IdentityAccess\Domain\Model\User\Image;

class UserDTODataTransformer extends BaseUserDTODataTransformer
{
    private $uploadDestination;

    public function __construct(string $uploadDestination = '')
    {
        $this->uploadDestination = $uploadDestination;
    }

    public function read() : array
    {
        if (null === $this->user) {
            return [];
        }

        return array_merge(parent::read(), [
            'user_id'    => $this->user->id()->id(),
            'user_name'  => $this->user->username()->username(),
            'first_name' => $this->firstName($this->user->fullName()),
            'last_name'  => $this->lastName($this->user->fullName()),
            'full_name'  => $this->fullName($this->user->fullName()),
            'image'      => $this->image($this->user->image()),
        ]);
    }

    private function firstName(FullName $fullName = null) : ?string
    {
        return $fullName instanceof FullName ? $fullName->firstName() : null;
    }

    private function lastName(FullName $fullName = null) : ?string
    {
        return $fullName instanceof FullName ? $fullName->lastName() : null;
    }

    private function fullName(FullName $fullName = null) : ?string
    {
        return $fullName instanceof FullName ? $fullName->fullName() : null;
    }

    private function image(Image $image = null) : ?string
    {
        return $image instanceof Image
            ? sprintf('%s/%s', $this->uploadDestination, $image->name()->filename())
            : null;
    }
}
