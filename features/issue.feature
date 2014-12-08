# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@issue
Feature: Manage issues
  In order to manage issues
  As a logged user
  I want to be able to add and edit issues

  Background:
    Given the following users exist:
      | firstName | lastName | email          | password |
      | Kreta     | User     | user@kreta.com | 123456   |
    And the following projects exist:
      | name         | shortName | creator        |
      | Test project | TPR       | user@kreta.com |
    And the following issues exist:
      | project      | title | description | reporter       | assignee       | type    | status | priority |
      | Test project | Test  | Description | user@kreta.com | user@kreta.com | initial | To do  | 1        |
    And I am a logged as 'user@kreta.com' with password '123456'

  Scenario: Adding a new issue
    Given I am on the homepage
    And I choose "TPR" project from user's project list
    And I click on add issue button
    When I fill in the following:
      | Name        | kreta |
      | Description | kreta |
    And I select "Kreta User" from "Assignee"
    And I press "Create"
    Then I should see "Issue saved successfully"

  Scenario: Editing an existing issue
    Given I am on the homepage
    And I click on edit button for issue 'Test'
    When I fill in "Description" with "Edited description"
    And I press "Update"
    Then I should see "Issue saved successfully"
    And I should see "Edited description"

  Scenario: Viewing an existing issue
    Given I am on the homepage
    And I click on view button for issue 'Test'
    Then I should see "VCS Integration"
    And I should see "Actions"
    And I should see "Comments"

  Scenario: Changing issues current status
    Given I am on the homepage
    And I click on view button for issue 'Test'
    When I follow "Start progress"
    Then I should see "Status changed successfully"

  Scenario: Adding a comment
    Given I am on the homepage
    And I click on view button for issue 'Test'
    When I fill in "kreta_core_comment_type_description" with "New comment!!"
    And I press "Send"
    Then I should see "Comment added successfully"
    And I should see "New comment!!"

