<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\FixturesBundle\DataFixtures\DataFixtures;

/**
 * Class LoadUserData.
 *
 * @package Kreta\FixturesBundle\DataFixtures\ORM
 */
class LoadUserData extends DataFixtures
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = $this->createUser('kreta@kreta.com', array('ROLE_ADMIN'));

        $manager->persist($user);

        for ($i = 0; $i < 50; $i++) {
            $user = $this->createUser('user' . $i . '@kreta.com');

            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 0;
    }

    /**
     * Returns a new instance of user with vales.
     *
     * @param string   $email The email
     * @param string[] $roles The array that contains roles
     *
     * @return \Kreta\CoreBundle\\Model\Interfaces\UserInterface
     */
    protected function createUser($email, $roles = array('ROLE_USER'))
    {
        $user = $this->container->get('kreta_core.factory_user')->create();
        $user->setFirstname('Name');
        $user->setLastname('Surname');
        $user->setEmail($email);
        $user->setPlainPassword(123456);
        $user->setRoles($roles);
        $user->setEnabled(true);

        return $user;
    }
}
