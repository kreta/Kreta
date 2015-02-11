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

use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Kreta\Bundle\CoreBundle\Behat\Traits\DatabaseContextTrait;

/**
 * Class WebContext.
 *
 * @package Kreta\Bundle\WebBundle\Behat
 */
class WebContext extends MinkContext implements KernelAwareContext
{
    use DatabaseContextTrait;

    /**
     * Log into the app with username and password given.
     *
     * @param string $user     The username
     * @param string $password The password
     *
     * @return void
     *
     * @Given /^I am a logged as '([^"]*)' with password '([^"]*)'$/
     */
    public function iAmALoggedUser($user, $password)
    {
        $this->visitPath('/login');
//        echo $this->getContainer()->get('kernel')->getRootDir();
//        var_dump($this->getSession()->getPage()->getContent() . "\n");
//        echo($this->getSession()->getPage()->getContent());die();
        $this->fillField('username', $user);
        $this->fillField('password', $password);
        $this->pressButton('Login');
    }

    /**
     * Clicks on "add" issue button.
     *
     * @return void
     *
     * @Given /^I click on add issue button$/
     */
    public function iClickOnAddIssueButton()
    {
        $this->clickLink('add-issue');
    }

    /**
     * Clicks on "edit" issue button.
     *
     * @param string $button    The button
     * @param string $issueName The issue name
     *
     * @return void
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     *
     * @Given /^I click on ([^"]*) button for issue '([^"]*)'$/
     */
    public function iClickOnEditButtonForIssue($button, $issueName)
    {
        $issuesEls = $this->getSession()->getPage()->findAll('css', '.kreta-mini-issue');

        foreach ($issuesEls as $issueEl) {
            if ($issueName === $issueEl->find('css', 'h3')->getText()) {
                $issueEl->find('css', '.' . $button . '-issue')->click();

                return;
            }
        }
        throw new ElementNotFoundException($this->getSession());
    }

    /**
     * Chooses the project from users project list.
     *
     * @param string $projectShortName The project short name
     *
     * @return void
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     *
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
     * Views unread notifications.
     *
     * @param int $amount The amount of notifications
     *
     * @return void
     * @throws \Exception when the unread notification amount does not match
     *
     * @Then /^I should see (\d+) unread notifications$/
     */
    public function iShouldSeeUnreadNotification($amount)
    {
        $icon = $this->getSession()->getPage()->find('css', '.kreta-notification-count');
        if ($icon->find('css', 'span')->getText() != $amount) {
            throw new \Exception('Unread notification amount does not match');
        }
    }

    /**
     * Clicks in notification inbox icon.
     *
     * @return void
     * @throws \Exception when the icon not found
     *
     * @When I click in notification inbox icon
     */
    public function iClickInNotificationInboxIcon()
    {
        $icon = $this->getSession()->getPage()->find('css', '.kreta-notification-count');
        if (!$icon) {
            throw new \Exception('Icon not found');
        }
        $icon->click();
    }
}
