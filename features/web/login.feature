# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@web
Feature: Manage authentication
  In order to manage authentication
  As a logged user
  I want to be able to register, login and logout

  Background:
    Given the following users exist:
      | firstName | lastName | email          | password |
      | Kreta     | User     | user@kreta.com | 123456   |

  Scenario: Login successfully
    Given I am on the homepage
    And I follow "Login"
    When I fill in the following:
      | username | user@kreta.com |
      | password | 123456         |
    And I press "Login"
    Then I should be on the homepage

  Scenario: Login with invalid credentials
    Given I am on the homepage
    And I follow "Login"
    When I fill in the following:
      | username | invalid@kreta.com |
      | password | invalid           |
    And I press "Login"
    Then I should see "Invalid credentials."

  Scenario: Registering into Kreta
    Given I am on the homepage
    And I follow "Sign up"
    When I fill in the following:
      | fos_user_registration_form_username             | new@kreta.com |
      | fos_user_registration_form_email                | new@kreta.com |
      | fos_user_registration_form_plainPassword_first  | 11111         |
      | fos_user_registration_form_plainPassword_second | 11111         |
    And I press "Register"
    Then I should see "An email has been sent to new@kreta.com"
