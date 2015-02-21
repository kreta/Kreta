# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@api-o
Feature: Manage time entry
  In order to manage time entries
  As an API time entry
  I want to be able to GET, POST, PUT and DELETE time entries

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
    And the following statuses exist:
      | id | color   | name        | workflow   |
      | 0  | #27ae60 | Open        | Workflow 1 |
      | 1  | #2c3e50 | In progress | Workflow 1 |
      | 2  | #f1c40f | Resolved    | Workflow 1 |
      | 3  | #c0392b | Closed      | Workflow 1 |
      | 4  | #27ae60 | Reopened    | Workflow 1 |
    And the following participants exist:
      | project        | user            | role             |
      | Test project 1 | user3@kreta.com | ROLE_PARTICIPANT |
      | Test project 1 | user2@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user2@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user4@kreta.com | ROLE_PARTICIPANT |
    And the following issues exist:
      | id | numericId | project        | title        | description  | reporter       | assignee       | type | status | priority | createdAt  |
      | 0  | 1         | Test project 1 | Test issue 1 | Description  | user@kreta.com | user@kreta.com | 4    | Open   | 1        | 2014-12-15 |
      | 1  | 2         | Test project 2 | Test issue 2 | Description2 | user@kreta.com | user@kreta.com | 4    | Open   | 1        | 2014-12-15 |
    And the following time entries exist:
      | id | dateReported | description                 | issue        | timeSpent |
      | 0  | 2015-02-15   | Description of time entry 0 | Test issue 1 | 90        |
      | 1  | 2015-02-20   | Description of time entry 0 | Test issue 2 | 200       |
      | 2  | 2015-02-10   | Description of time entry 0 | Test issue 1 | 3000      |
      | 3  | 2015-02-05   | Description of time entry 0 | Test issue 1 | 200       |
      | 4  | 2015-02-17   | Description of time entry 0 | Test issue 1 | 100       |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |
      | access-token-3 | null      | user  | user4@kreta.com |

  Scenario: Getting all the time entries of project 0 and issue 0
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0/time-entries"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "3",
        "date_reported": "2015-02-05T00:00:00+0100",
        "description": "Description of time entry 0",
        "time_spent": 200,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries/3"
          },
          "timeEntries": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }, {
        "id": "2",
        "date_reported": "2015-02-10T00:00:00+0100",
        "description": "Description of time entry 0",
        "time_spent": 3000,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries/2"
          },
          "timeEntries": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }, {
        "id": "0",
        "date_reported": "2015-02-15T00:00:00+0100",
        "description": "Description of time entry 0",
        "time_spent": 90,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries/0"
          },
          "timeEntries": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }, {
        "id": "4",
        "date_reported": "2015-02-17T00:00:00+0100",
        "description": "Description of time entry 0",
        "time_spent": 100,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries/4"
          },
          "timeEntries": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }]
    """

  Scenario: Getting all the time entries of project 0 and issue 0 order by time spent
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0/time-entries?sort=timeSpent"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "0",
        "date_reported": "2015-02-15T00:00:00+0100",
        "description": "Description of time entry 0",
        "time_spent": 90,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries/0"
          },
          "timeEntries": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }, {
        "id":"4",
        "date_reported": "2015-02-17T00:00:00+0100",
        "description": "Description of time entry 0",
        "time_spent": 100,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries/4"
          },
          "timeEntries": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }, {
        "id": "3",
        "date_reported": "2015-02-05T00:00:00+0100",
        "description": "Description of time entry 0",
        "time_spent": 200,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries/3"
          },
          "timeEntries": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }, {
        "id": "2",
        "date_reported": "2015-02-10T00:00:00+0100",
        "description": "Description of time entry 0",
        "time_spent": 3000,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries/2"
          },
          "timeEntries": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }]
    """

  Scenario: Getting all the time entries of project 0 and issue 0 with limit 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0/time-entries?limit=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "3",
        "date_reported": "2015-02-05T00:00:00+0100",
        "description": "Description of time entry 0",
        "time_spent": 200,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries/3"
          },
          "timeEntries": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }, {
        "id": "2",
        "date_reported": "2015-02-10T00:00:00+0100",
        "description": "Description of time entry 0",
        "time_spent": 3000,
        "_links": {
          "self": {
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/time-entries/2"
          },
          "timeEntries": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries"
          },
          "issues":{
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }]
    """

  Scenario: Getting all the time entries of project 0 and issue 0 with offset 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0/time-entries?offset=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "0",
        "date_reported": "2015-02-15T00:00:00+0100",
        "description": "Description of time entry 0",
        "time_spent": 90,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries/0"
          },
          "timeEntries": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }, {
        "id": "4",
        "date_reported": "2015-02-17T00:00:00+0100",
        "description": "Description of time entry 0",
        "time_spent": 100,
        "_links": {
          "self": {
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/time-entries/4"
          },
          "timeEntries": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }]
    """

  Scenario: Getting all the time entries with user which is not a project participant
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0/time-entries"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting all the time entries of unknown project
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/unknown-project/issues/0/time-entries"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting all the time entries of unknown issue
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/unknown-issue/time-entries"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting the 0 time entry
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0/time-entries/0"
    Then the response code should be 200
    And print response
    And the response should contain json:
    """
      {
        "id": "0",
        "date_reported": "2015-02-15T00:00:00+0100",
        "description": "Description of time entry 0",
        "time_spent": 90,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries/0"
          },
          "timeEntries": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/time-entries"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }
    """

  Scenario: Getting the 0 time entry with user that is not allowed
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0/time-entries/2"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting the 0 time entries of unknown project
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/unknown-project/issues/0/time-entries/0"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting the 0 time entries of unknown issue
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/unknown-issue/time-entries/0"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting the unknown time entry
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/unknown-project/issues/0/time-entries/unknown-time-entry"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """
