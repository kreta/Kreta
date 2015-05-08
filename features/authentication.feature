# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@authentication 
Feature: Manage authentication
  In order to manage authentication
  As a logged user
  I want to be able to register, login and logout

  Background:
    Given the following users exist:
      | firstName | lastName | email          | password |
      | Kreta     | User     | user@kreta.com | 123456   |
    And the OAuth client is loaded

  Scenario: Login successfully
    Given I am on "/login"
    When I fill in the following:
      | username | user@kreta.com |
      | password | 123456         |
    And I press "Login"
    Then I should be on the dashboard
    And I should see refresh_token and access_token cookies

  Scenario: Logout successfully
    Given I am a logged as 'user@kreta.com' with password '123456'
    Then I follow "Logout"
    Then I should be on the login
    And I should not see refresh_token and access_token cookies

  Scenario: Login with invalid credentials
    Given I am on "/login"
    When I fill in the following:
      | username | invalid@kreta.com |
      | password | invalid           |
    And I press "Login"
    Then I should see "Invalid credentials."
