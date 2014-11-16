# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@notification
Feature: Managing notifications
  In order to manage notifications
  As a logged user
  I want to be able to see my notifications

  Background:
    Given the following users exist:
      | firstName | lastName | email          | password |
      | Kreta     | User     | user@kreta.com | 123456   |
    And the following projects exist:
      | name         | shortName |
      | Test project | TPR       |
    And the following notifications exist:
      | title               | description              | projectName  | userEmail      | read  | resourceUrl | webUrl | type      |
      | Test notification 1 | Test notification 1 desc | Test project | user@kreta.com | true  | /           | /      | issue_new |
      | Test notification 2 | Test notification 2 desc | Test project | user@kreta.com | false | /           | /      | issue_new |
      | Test notification 3 | Test notification 3 desc | Test project | user@kreta.com | false | /           | /      | issue_new |
    And I am a logged as 'user@kreta.com' with password '123456'

  Scenario: Checking unread notification count
    Given I am on the homepage
    Then I should see 2 unread notifications

  Scenario: Reading notifications
    Given I am on the homepage
    When I click in notification inbox icon
    Then I should see "Test notification 2"
    And I should see "Test notification 3"
    And I should not see "Test notification 1"
