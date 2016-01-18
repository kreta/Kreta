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

namespace Kreta\Bundle\WebBundle\Behat\Context;

use Behat\MinkExtension\Context\MinkContext;

/**
 * Class WebContext.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class WebContext extends MinkContext
{
    /**
     * Saves the html into a file of the current view.
     *
     * @return void
     *
     * @Then /^I save html of current view$/
     */
    public function saveHtmlFromCurrentView()
    {
        file_put_contents('behat-page.html', $this->getSession()->getDriver()->getContent());
    }

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
        $this->fillField('username', $user);
        $this->fillField('password', $password);
        $this->pressButton('Login');
    }

    /**
     * Views refresh token and access token cookies.
     *
     * @return void
     * @throws \Exception when the tokens does not match
     *
     * @Then /^I should see refresh_token and access_token cookies$/
     */
    public function iShouldSeeRefreshAndAccessTokensCookies()
    {
        $session = $this->getSession();
        $refreshToken = $session->getCookie('refresh_token');
        $accessToken = $session->getCookie('access_token');
        if (!$refreshToken || !$accessToken) {
            throw new \Exception('The tokens are not appear correctly');
        }
    }

    /**
     * Checks refresh token and access token cookies are not stored.
     *
     * @return void
     * @throws \Exception when the cookies are here
     *
     * @Then /^I should not see refresh_token and access_token cookies$/
     */
    public function iShouldNotSeeRefreshAndAccessTokensCookies()
    {
        $session = $this->getSession();
        $refreshToken = $session->getCookie('refresh_token');
        $accessToken = $session->getCookie('access_token');
        if ($refreshToken || $accessToken) {
            throw new \Exception('The cookies are here yet');
        }
    }

    /**
     * Presses logout with specified id|name|title|alt|value.
     *
     * @return void
     *
     * @When /^(?:|I )press logout$/
     */
    public function pressLogout()
    {
        $this->getSession()->getPage()->clickLink('logout');
    }

    /**
     * Checks, that current page is the dashboard.
     *
     * @return void
     *
     * @Then /^(?:|I )should be on (?:|the )dashboard$/
     */
    public function assertDashboard()
    {
        $this->assertSession()->addressEquals($this->locatePath('/'));
    }

    /**
     * Checks, that current page is the landing page.
     *
     * @return void
     *
     * @Then /^(?:|I )should be on (?:|the )landing$/
     */
    public function assertLanding()
    {
        $this->assertSession()->addressEquals($this->locatePath('/'));
    }

    /**
     * Checks, that current page is the login page.
     *
     * @return void
     *
     * @Then /^(?:|I )should be on (?:|the )login/
     */
    public function assertLogin()
    {
        $this->assertSession()->addressEquals($this->locatePath('/login'));
    }
}
