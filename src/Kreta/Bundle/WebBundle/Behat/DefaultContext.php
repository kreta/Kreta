<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\Behat;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

/**
 * Class DefaultContext.
 *
 * @package Kreta\Bundle\WebBundle\Behat
 */
class DefaultContext extends MinkContext implements KernelAwareContext
{
    use KernelDictionary;

    /**
     * @BeforeScenario
     */
    public function purgeDatabase(BeforeScenarioScope $scope)
    {
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $entityManager->getConnection()->executeUpdate("SET foreign_key_checks = 0;");

        $purger = new ORMPurger($entityManager);
        $purger->purge();

        $entityManager->getConnection()->executeUpdate("SET foreign_key_checks = 1;");
    }

    /**
     * @Given /^I am a logged as '([^"]*)' with password '([^"]*)'$/
     */
    public function iAmALoggedUser($user, $password)
    {
        $this->visitPath('/login');
        $this->fillField('username', $user);
        $this->fillField('password', $password);
        $this->pressButton('Login');
    }

    /**
     * @Given /^I click on add issue button$/
     */
    public function iClickOnAddIssueButton()
    {
        $this->clickLink('add-issue');
    }

    /**
     * @Given /^I click on ([^"]*) button for issue '([^"]*)'$/
     */
    public function iClickOnEditButtonForIssue($button, $issueName)
    {
        $issuesEls = $this->getSession()->getPage()->findAll('css', '.kreta-mini-issue');

        foreach ($issuesEls as $issueEl) {
            if ($issueName === $issueEl->find('css', 'h3')->getText()) {
                $issueEl->find('css', ".$button-issue")->click();

                return;
            }
        }

        throw new ElementNotFoundException($this->getSession());
    }

    /**
     * @Given /^I choose "([^"]*)" project from user's project list$/
     */
    public function iChooseProjectFromUsersProjectList($projectShortName)
    {
        $projectEls = $this->getSession()->getPage()->findAll('css', '.title-container');
        foreach ($projectEls as $projectEl) {
            if ($projectShortName === $projectEl->find('css', 'a')->getText()) {
                $projectEl->find('css', 'a')->click();

                return;
            }
        }

        throw new ElementNotFoundException($this->getSession());
    }

    /**
     * @Then /^I should see (\d+) unread notifications$/
     */
    public function iShouldSeeUnreadNotification($amount)
    {
        $icon = $this->getSession()->getPage()->find('css', '.kreta-notification-count');
        if($icon->find('css','span')->getText() != $amount) {
            throw new \Exception('Unread notification amount does not match');
        }
    }

    /**
     * @When I click in notification inbox icon
     */
    public function iClickInNotificationInboxIcon()
    {
        $icon = $this->getSession()->getPage()->find('css', '.kreta-notification-count');
        if(!$icon) {
            throw new \Exception('Icon not found');
        }
        $icon->click();
    }
}
