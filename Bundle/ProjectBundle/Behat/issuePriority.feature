# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@issuePriority
Feature: Manage issue priority
  In order to manage issue priorities
  As an API issue priorities
  I want to be able to GET, POST and DELETE issue priorities

  Background:
    Given the following users exist:
      | id | firstName | lastName | username | email           | password | createdAt  |
      | 0  | Kreta     | User     | user     | user@kreta.com  | 123456   | 2014-10-20 |
      | 1  | Kreta     | User2    | user2    | user2@kreta.com | 123456   | 2014-10-20 |
      | 2  | Kreta     | User3    | user3    | user3@kreta.com | 123456   | 2014-10-20 |
      | 3  | Kreta     | User4    | user4    | user4@kreta.com | 123456   | 2014-10-20 |
    And the following workflows exist:
      | id | name       | creator        |
      | 0  | Workflow 1 | user@kreta.com |
      | 1  | Workflow 2 | user@kreta.com |
    And the following projects exist:
      | id | name           | shortName | creator        | workflow   |
      | 0  | Test project 1 | TPR1      | user@kreta.com | Workflow 1 |
      | 1  | Test project 2 | TPR2      | user@kreta.com | Workflow 2 |
    And the following issue priorities exist:
      | id | name    | project        |
      | 0  | Low     | Test project 1 |
      | 1  | Medium  | Test project 1 |
      | 2  | High    | Test project 1 |
      | 3  | Blocker | Test project 1 |
      | 4  | Low     | Test project 2 |
      | 5  | Medium  | Test project 2 |
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

  Scenario: Getting all the issue priorities of project 0
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issue-priorities"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "3",
          "name": "Blocker",
          "_links": {
            "issue_priorities": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-priorities"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        },
        {
          "id": "2",
          "name": "High",
          "_links": {
            "issue_priorities": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-priorities"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        },
        {
          "id": "0",
          "name": "Low",
          "_links": {
            "issue_priorities": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-priorities"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        },
        {
          "id": "1",
          "name": "Medium",
          "_links": {
            "issue_priorities": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-priorities"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        }
      ]
    """

  Scenario: Getting all the issue priorities of project 0 with user which is not a project participant
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/app_test.php/api/projects/0/issue-priorities"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting all the issue priorities of project unknown project
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/app_test.php/api/projects/unknown-project/issue-priorities"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting all the issue priorities of project 0 filter by name=Bug
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issue-priorities?q=Low"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "name": "Low",
          "_links": {
            "issue_priorities": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-priorities"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        }
      ]
    """

  Scenario: Getting all the issue priorities of project 0 with limit 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issue-priorities?limit=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "3",
          "name": "Blocker",
          "_links": {
            "issue_priorities": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-priorities"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        },
        {
          "id": "2",
          "name": "High",
          "_links": {
            "issue_priorities": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-priorities"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        }
      ]
    """

  Scenario: Getting all the issue priorities of project 0 with offset 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issue-priorities?offset=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "name": "Low",
          "_links": {
            "issue_priorities": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-priorities"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        },
        {
          "id": "1",
          "name": "Medium",
          "_links": {
            "issue_priorities": {
              "href": "http://localhost/app_test.php/api/projects/0/issue-priorities"
            },
            "project": {
              "href": "http://localhost/app_test.php/api/projects/0"
            }
          }
        }
      ]
    """

  Scenario: Creating a issue priority
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/issue-priorities" with body:
    """
      {
        "name": "New issue priority"
      }
    """
    Then the response code should be 201

  Scenario: Creating a issue priority with user which is not a project participant
    Given I am authenticating with "access-token-3" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/issue-priorities" with body:
    """
      {
        "name": "New issue priority"
      }
    """
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Creating a issue priority in unknown project
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/unknown-project/issue-priorities" with body:
    """
      {
        "name": "New issue priority"
      }
    """
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Creating a issue priority without name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/1/issue-priorities" with body:
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

  Scenario: Creating a issue priority with already exists name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/1/issue-priorities" with body:
    """
      {
        "name": "Low"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "name": [
          "A issue priority with identical name is already exists in this project"
        ]
      } 
    """

  Scenario: Deleting issue priority 0 of project 0
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/projects/0/issue-priorities/0"
    Then the response code should be 204

  Scenario: Deleting issue priority 0 with user which is not a project admin
    Given I am authenticating with "access-token-3" token
    When I send a DELETE request to "/app_test.php/api/projects/0/issue-priorities/0"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      } 
    """

  Scenario: Deleting issue priority 0 of unknown project
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/projects/unknown-project/issue-priorities/0"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      } 
    """
