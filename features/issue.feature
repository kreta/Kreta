@issue
Feature: Manage issues
  In order to manage issues
  As a logged user
  I want to be able to add and edit issues

  Background:
    Given the following users exist:
      | firstName | lastName | email          | password |
      | Kreta     | User     | user@kreta.com | 123456   |
    And I am a logged as 'user@kreta.com' with password '123456'

  Scenario: Adding a new issue
    Given I am on the homepage
    And I click on add issue button
    When I fill in the following:
      | Name        | kreta |
      | Description | kreta |
    And I select "user@kreta.com" from "Assigner"
    And I select "user@kreta.com" from "Assignee"
    And I press "Create"
    And print last response
    Then I should see "Issue created successfully"
