# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@issueType
Feature: Manage issue type
  In order to manage issue types
  As an API issue type
  I want to be able to GET, POST and DELETE issue types

  Background:
    Given the following users exist:
      | id | firstName | lastName | email           | password | createdAt  |
      | 0  | Kreta     | User     | user@kreta.com  | 123456   | 2014-10-20 |
      | 1  | Kreta     | User2    | user2@kreta.com | 123456   | 2014-10-20 |
      | 2  | Kreta     | User3    | user3@kreta.com | 123456   | 2014-10-20 |
      | 3  | Kreta     | User4    | user4@kreta.com | 123456   | 2014-10-20 |
    And the following workflows exist:
      | id | name       | creator        |
      | 0  | Workflow 1 | user@kreta.com |
      | 1  | Workflow 2 | user@kreta.com |
    And the following projects exist:
      | id | name           | shortName | creator        | workflow   |
      | 0  | Test project 1 | TPR1      | user@kreta.com | Workflow 1 |
      | 1  | Test project 2 | TPR2      | user@kreta.com | Workflow 2 |
    And the following issue types exist:
      | id | name        | project        |
      | 0  | Bug         | Test project 1 |
      | 1  | Epic        | Test project 1 |
      | 2  | New feature | Test project 1 |
      | 3  | Bug         | Test project 2 |
      | 4  | Error       | Test project 2 |
      | 5  | Story       | Test project 2 |
    And the following participants exist:
      | project        | user            | role             |
      | Test project 1 | user3@kreta.com | ROLE_PARTICIPANT |
      | Test project 1 | user2@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user2@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user4@kreta.com | ROLE_PARTICIPANT |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |
      | access-token-3 | null      | user  | user4@kreta.com |

  Scenario: Getting all the issue types of project 0
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issue-types"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "name": "Bug",
          "_links": {
            "issue_types": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-types"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        },
        {
          "id": "1",
          "name": "Epic",
          "_links": {
            "issue_types": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-types"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        },
        {
          "id": "2",
          "name": "New feature",
          "_links": {
            "issue_types": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-types"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        }
      ]
    """

  Scenario: Getting all the issue types of project 0 with user which is not a project participant
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/app_test.php/api/projects/0/issue-types"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting all the issue types of project unknown project
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/app_test.php/api/projects/unknown-project/issue-types"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting all the issue types of project 0 filter by name=Bug
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issue-types?q=Bug"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "name": "Bug",
          "_links": {
            "issue_types": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-types"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        }
      ]
    """

  Scenario: Getting all the labels of project 0 with limit 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issue-types?limit=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "name": "Bug",
          "_links": {
            "issue_types": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-types"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        },
        {
          "id": "1",
          "name": "Epic",
          "_links": {
            "issue_types": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-types"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        }
      ]
    """

  Scenario: Getting all the issue types of project 0 with offset 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issue-types?offset=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "2",
          "name": "New feature",
          "_links": {
            "issue_types": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-types"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        }
      ]
    """

  Scenario: Creating a issue type
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/issue-types" with body:
    """
      {
        "name": "New issue type"
      }
    """
    Then the response code should be 201

  Scenario: Creating a issue type with user which is not a project participant
    Given I am authenticating with "access-token-3" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/issue-types" with body:
    """
      {
        "name": "New issue type"
      }
    """
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Creating a issue type in unknown project
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/unknown-project/issue-types" with body:
    """
      {
        "name": "New issue type"
      }
    """
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Creating a issue type without name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/1/issue-types" with body:
    """
      {
        "name": ""
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "name": [
          "This value should not be blank."
        ]
      }
    """

  Scenario: Creating a issue type with already exists name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/1/issue-types" with body:
    """
      {
        "name": "Bug"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "name": [
          "A issue type with identical name is already exists in this project"
        ]
      } 
    """

  Scenario: Deleting issue type 0 of project 0
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/projects/0/issue-types/0"
    Then the response code should be 204

  Scenario: Deleting issue type 0 with user which is not a project admin
    Given I am authenticating with "access-token-3" token
    When I send a DELETE request to "/app_test.php/api/projects/0/issue-types/0"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      } 
    """

  Scenario: Deleting issue type 0 of unknown project
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/projects/unknown-project/issue-types/0"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      } 
    """
