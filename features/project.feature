# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@project
Feature: Manage project
  In order to manage projects
  As a logged user
  I want to be able to create projects

  Background:
    Given the following users exist:
      | firstName | lastName | email           | password |
      | Kreta     | User     | user@kreta.com  | 123456   |
      | Kreta     | User2    | user2@kreta.com | 123456   |
      | Kreta     | User3    | user3@kreta.com | 123456   |
    And the following projects exist:
      | name         | shortName | creator        |
      | Test project | TPR       | user@kreta.com |
    And the following participants exist:
      | project      | user            | role             |
      | Test project | user3@kreta.com | ROLE_PARTICIPANT |

  Scenario: Adding a new project
    Given I am a logged as 'user@kreta.com' with password '123456'
    And I am on homepage
    And I follow "Add project"
    When I fill in the following:
      | Name       | New project |
      | Short name | NPR         |
    And I press "Create"
    Then I should see "Project saved successfully"

  Scenario: Viewing a existing project
    Given I am a logged as 'user@kreta.com' with password '123456'
    And I am on homepage
    When I choose "TPR" project from user's project list
    Then I should see "Participants"
    And I should see "Project Issues"

  Scenario: Adding a participant to project
    Given I am a logged as 'user@kreta.com' with password '123456'
    And I am on homepage
    And I choose "TPR" project from user's project list
    When I fill in "email" with "user2@kreta.com"
    And I press "Add user to project"
    Then I should see "Participant added successfully"

  Scenario: Adding a participant with unregistered email
    Given I am a logged as 'user@kreta.com' with password '123456'
    And I am on homepage
    And I choose "TPR" project from user's project list
    When I fill in "email" with "unregistered@kreta.com"
    And I press "Add user to project"
    Then I should see "User not found"

  Scenario: Trying to add a participant to a project without being project admin
    Given I am a logged as 'user3@kreta.com' with password '123456'
    And I am on homepage
    When I choose "TPR" project from user's project list
    Then I should not see "Add user to project"
