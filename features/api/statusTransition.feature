# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@api
Feature: Manage status transition
  In order to manage status transitions
  As an API status transition
  I want to be able to GET, POST, PUT and DELETE statuses

  Background:
    Given the following users exist:
      | id | firstName | lastName | email           | password | createdAt  |
      | 0  | Kreta     | User     | user@kreta.com  | 123456   | 2014-10-20 |
      | 1  | Kreta     | User2    | user2@kreta.com | 123456   | 2014-10-20 |
      | 2  | Kreta     | User3    | user3@kreta.com | 123456   | 2014-10-20 |
    And the following workflows exist:
      | id | name       | creator        |
      | 0  | Workflow 1 | user@kreta.com |
      | 1  | Workflow 2 | user@kreta.com |
    And the following projects exist:
      | id | name           | shortName | creator        | workflow   |
      | 0  | Test project 1 | TPR1      | user@kreta.com | Workflow 1 |
      | 1  | Test project 2 | TPR2      | user@kreta.com | Workflow 2 |
    And the following statuses exist:
      | id | color   | name        | workflow   |
      | 0  | #27ae60 | Open        | Workflow 1 |
      | 1  | #2c3e50 | In progress | Workflow 1 |
      | 2  | #f1c40f | Resolved    | Workflow 1 |
    And the following status transitions exist:
      | id | name            | status      | initialStates    |
      | 0  | Start progress  | Open        | In progress      |
      | 1  | Reopen progress | In progress | Open,Resolved    |
      | 2  | Finish progress | Resolved    | Open,In progress |
    And the following participants exist:
      | project        | user            | role             |
      | Test project 2 | user3@kreta.com | ROLE_PARTICIPANT |
      | Test project 1 | user2@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user2@kreta.com | ROLE_PARTICIPANT |
    And the following issues exist:
      | id | numericId | project        | title        | description | reporter       | assignee       | type    | status   | priority | createdAt  |
      | 0  | 1         | Test project 1 | Test issue 1 | Description | user@kreta.com | user@kreta.com | initial | Open     | 1        | 2014-10-21 |
      | 1  | 2         | Test project 1 | Test issue 2 | Description | user@kreta.com | user@kreta.com | initial | Resolved | 1        | 2014-10-21 |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |

  Scenario: Getting all the transitions of workflow 0
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "initial_states": [{
          "type": "normal",
          "name": "In progress",
          "id": "1",
          "color": "#2c3e50"
        }],
        "name": "Start progress",
        "id": "0",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/0/transitions/0"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/0/transitions"
          },
          "workflow": {
            "href": "http://localhost/app_test.php/api/workflows/0"
          }
        }
      }, {
        "initial_states": [{
          "type": "normal",
          "name": "Open",
          "id": "0",
          "color": "#27ae60"
        }, {
          "type": "normal",
          "name": "Resolved",
          "id": "2",
          "color": "#f1c40f"
        }],
        "name": "Reopen progress",
        "id": "1",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/0/transitions/1"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/0/transitions"
          },
          "workflow": {
            "href": "http://localhost/app_test.php/api/workflows/0"
          }
        }
      }, {
        "initial_states": [{
          "type": "normal",
          "name": "Open",
          "id": "0",
          "color": "#27ae60"
        }, {
          "type": "normal",
          "name": "In progress",
          "id": "1",
          "color": "#2c3e50"
        }],
        "name": "Finish progress",
        "id": "2",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/0/transitions/2"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/0/transitions"
          },
          "workflow": {
            "href": "http://localhost/app_test.php/api/workflows/0"
          }
        }
      }]
    """

  Scenario: Getting all the transitions of unknown workflow
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/unknown-workflow/transitions"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-workflow id"
      }
    """

  Scenario: Getting the 0 transition
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/0"
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "initial_states": [{
          "type": "normal",
          "name": "In progress",
          "id": "1",
          "color": "#2c3e50"
        }],
        "name": "Start progress",
        "id": "0",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/0/transitions/0"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/0/transitions"
          },
          "workflow": {
            "href": "http://localhost/app_test.php/api/workflows/0"
          }
        }
      }
    """

  Scenario: Getting the 0 transition with user which is not a participant
    Given I am authenticating with "access-token-2" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/0"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting the unknown transition
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/unknown-transition"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-transition id"
      }
    """

  Scenario: Getting the transition of unknown workflow
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/unknown-workflow/transitions/0"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-workflow id"
      }
    """

  Scenario: Deleting the 0 transition with user which is not workflow creator
    Given I am authenticating with "access-token-2" token
    When I send a DELETE request to "/app_test.php/api/workflows/0/transitions/0"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Deleting the 1 transition which is in use by an issue
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/workflows/0/transitions/1"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Remove operation has been cancelled, the transition is currently in use"
      }
    """

  Scenario: Deleting the transition of unknown workflow
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/workflows/unknown-workflow/transitions/0"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-workflow id"
      }
    """

  Scenario: Deleting the 0 transition
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/workflows/0/transitions/0"
    Then the response code should be 204
    And the response should contain json:
    """
      {
      }
    """

  Scenario: Deleting the unknown transition
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/workflows/0/transitions/unknown-transition"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-transition id"
      }
    """

  Scenario: Getting the initial statuses of 0 transition with user which is not workflow creator
    Given I am authenticating with "access-token-2" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/0/initial-statuses"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting the initial statuses of 0 transition of unknown workflow
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/unknown-workflow/transitions/0/initial-statuses"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-workflow id"
      }
    """

  Scenario: Getting the initial statuses of unknown transition
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/unknown-transition/initial-statuses"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-transition id"
      }
    """

  Scenario: Getting the initial statuses of 0 transition
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/0/initial-statuses"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "type": "normal",
        "name": "In progress",
        "id": "1",
        "color": "#2c3e50"
      }]
    """

  Scenario: Getting the initial statuses of 1 transition
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/1/initial-statuses"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "type": "normal",
        "name": "Open",
        "id": "0",
        "color": "#27ae60"
      }, {
        "type": "normal",
        "name": "Resolved",
        "id": "2",
        "color": "#f1c40f"
      }]
    """

  Scenario: Getting the 0 initial status of 0 transition with user which is not workflow creator
    Given I am authenticating with "access-token-2" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/0/initial-statuses/0"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting the 0 initial status of 0 transition of unknown workflow
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/unknown-workflow/transitions/0/initial-statuses/0"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-workflow id"
      }
    """

  Scenario: Getting the 0 initial status of unknown transition
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/unknown-transition/initial-statuses/0"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-transition id"
      }
    """

  Scenario: Getting the unknown initial status of 0 transition
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/0/initial-statuses/unknown-initial-status"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any initial status with unknown-initial-status id"
      }
    """

  Scenario: Getting the 0 initial status of 0 transition
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/0/initial-statuses/1"
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "type": "normal",
        "name": "In progress",
        "id": "1",
        "color": "#2c3e50"
      }
    """

  Scenario: Getting the end status of 0 transition with user which is not workflow creator
    Given I am authenticating with "access-token-2" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/0/end-status"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting the end status of 0 transition of unknown workflow
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/unknown-workflow/transitions/0/end-status"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-workflow id"
      }
    """

  Scenario: Getting the end status of unknown transition
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/unknown-transition/end-status"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-transition id"
      }
    """

  Scenario: Getting the end status of 0 transition
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/0/end-status"
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "type": "normal",
        "name": "Open",
        "id": "0",
        "color": "#27ae60"
      }
    """

  Scenario: Deleting the 0 initial status of 0 transition with user which is not workflow creator
    Given I am authenticating with "access-token-2" token
    When I send a DELETE request to "/app_test.php/api/workflows/0/transitions/0/initial-statuses/0"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Deleting the 0 initial status of 0 transition of unknown workflow
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/workflows/unknown-workflow/transitions/0/initial-statuses/0"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-workflow id"
      }
    """

  Scenario: Deleting the 0 initial status of unknown transition
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/0/transitions/unknown-transition/initial-statuses/0"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-transition id"
      }
    """

  Scenario: Deleting the unknown initial status of 0 transition
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/workflows/0/transitions/0/initial-statuses/unknown-initial-status"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any initial status with unknown-initial-status id"
      }
    """

  Scenario: Deleting the 0 initial status where the transition is in use by an issue
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/workflows/0/transitions/1/initial-statuses/0"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Remove operation has been cancelled, the transition is currently in use"
      }
    """

  Scenario: Deleting the 0 initial status of 0 transition
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/workflows/0/transitions/0/initial-statuses/1"
    Then the response code should be 204
    And the response should contain json:
    """
      {}
    """
