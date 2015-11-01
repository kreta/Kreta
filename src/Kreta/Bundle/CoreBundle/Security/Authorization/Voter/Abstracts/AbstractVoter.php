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

namespace Kreta\Bundle\CoreBundle\Security\Authorization\Voter\Abstracts;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Abstract class AbstractVoter.
 */
abstract class AbstractVoter implements VoterInterface
{
    /**
     * Array that contains attributes that supports the voter.
     *
     * @var string[]
     */
    protected $attributes = [];

    /**
     * Namespace of the supported class.
     *
     * @var string
     */
    protected $supportedClass;

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return in_array($attribute, $this->attributes, true);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $this->supportedClass === $class || is_subclass_of($class, $this->supportedClass);
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if (!$this->supportsClass(get_class($object))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        if (count($attributes) !== 1) {
            throw new \InvalidArgumentException('Only one attribute allowed.');
        }

        $attribute = $attributes[0];

        if (!$this->supportsAttribute($attribute)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }

        return $this->checkAttribute($user, $object, $attribute);
    }

    /**
     * Checks the attribute given returning -1, 0 or 1 depending on the access is denied, abstain or granted.
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $user      The user
     * @param Object                                              $object    The object
     * @param string                                              $attribute The attribute
     *
     * @return int
     */
    abstract public function checkAttribute(UserInterface $user, $object, $attribute);
}
