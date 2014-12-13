# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@api
Feature: Manage issue
  In order to manage issues
  As an API issue
  I want to be able to GET, POST and PUT issues

  Background:
    Given the following users exist:
      | id | firstName | lastName | email           | password | createdAt  |
      | 0  | Kreta     | User     | user@kreta.com  | 123456   | 2014-10-20 |
      | 1  | Kreta     | User2    | user2@kreta.com | 123456   | 2014-10-20 |
      | 2  | Kreta     | User3    | user3@kreta.com | 123456   | 2014-10-20 |
      | 3  | Kreta     | User4    | user4@kreta.com | 123456   | 2014-10-20 |
    And the following projects exist:
      | id | name           | shortName | creator        |
      | 0  | Test project 1 | TPR1      | user@kreta.com |
      | 1  | Test project 2 | TPR2      | user@kreta.com |
    And the following statuses exist:
      | id | color   | name        | project        |
      | 0  | #27ae60 | Open        | Test project 1 |
      | 1  | #2c3e50 | In progress | Test project 1 |
      | 2  | #f1c40f | Resolved    | Test project 1 |
      | 3  | #c0392b | Closed      | Test project 1 |
      | 4  | #27ae60 | Reopened    | Test project 1 |
    And the following participants exist:
      | project        | user            | role             |
      | Test project 1 | user3@kreta.com | ROLE_PARTICIPANT |
      | Test project 1 | user2@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user2@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user4@kreta.com | ROLE_PARTICIPANT |
    And the following issues exist:
      | id | numericId | project        | title        | description | reporter        | assignee        | type    | status   | priority | createdAt  |
      | 0  | 1         | Test project 1 | Test issue 1 | Description | user@kreta.com  | user@kreta.com  | initial | Open     | 1        | 2014-10-21 |
      | 1  | 2         | Test project 1 | Test issue 2 | Description | user@kreta.com  | user@kreta.com  | initial | Resolved | 1        | 2014-10-21 |
      | 2  | 1         | Test project 2 | Test issue 1 | Description | user@kreta.com  | user4@kreta.com | initial | Resolved | 1        | 2014-10-21 |
      | 3  | 2         | Test project 2 | Test issue 1 | Description | user4@kreta.com | user@kreta.com  | initial | Resolved | 1        | 2014-10-21 |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |
      | access-token-3 | null      | user  | user4@kreta.com |

  Scenario: Getting all the issues of project 0
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues"
    Then the response code should be 200
    And print response
    And the response should contain json:
    """
    []
    """

  Scenario: Getting the 0 issue
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0"
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "comments": [],
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "Description",
        "labels": [],
        "priority": 1,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "id": "0",
          "color": "#27ae60"
        },
        "title": "Test issue 1",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }
    """

  Scenario: Getting the 0 issue with user which is not a participant
    Given I am authenticating with "access-token-2" token
    When I send a GET request to "/app_test.php/api/projects/1/issues/2"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting the unknown issue
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/unknown-issue"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-issue id"
      }
    """

  Scenario: Creating a issue
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/issues" with body:
    """
      {
        "title": "New issue",
        "description": "The description",
        "type": "0",
        "priority": "0",
        "assignee": "1"
      }
    """
    Then the response code should be 201

  Scenario: Creating a issue assigning to user which is not a project participant
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/1/issues" with body:
    """
      {
        "title": "New issue",
        "description": "The description",
        "type": "0",
        "priority": "0",
        "assignee": "2"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "assignee": [
          "This value is not valid."
        ]
      }
    """

  Scenario: Creating a issue without parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/1/issues" with body:
    """
      {
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "title": [],
        "description": [],
        "type": [],
        "priority": [],
        "assignee": []
      }
    """

  Scenario: Creating a issue without required parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/1/issues" with body:
    """
      {
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "title": [
          "This value should not be blank."
        ],
        "type": [
          "This value should not be blank."
        ],
        "priority": [
          "This value should not be blank."
        ]
      }
    """

  Scenario: Creating a issue with already exists title
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/issues" with body:
    """
      {
        "title": "Test issue 1",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "title": [
          "An issue with identical title is already exist in this project"
        ]
      } 
    """

  Scenario: Creating an issue with user which is not a participant
    Given I am authenticating with "access-token-2" token
    When I send a POST request to "/app_test.php/api/projects/1/issues" with body:
    """
      {
        "title": "New issue",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Updating the 0 issue
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/0/issues/0" with body:
    """
      {
        "title": "Test issue 1",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "assignee": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "comments": [],
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "The description",
        "labels": [],
        "priority": 0,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "id": "0",
          "color": "#27ae60"
        },
        "title": "Test issue 1",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      } 
    """

  Scenario: Updating the 0 issue without parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/0/issues/0" with body:
    """
      {
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "title": [],
        "description": [],
        "type": [],
        "priority": [],
        "assignee": []
      }
    """

  Scenario: Updating the 0 issue without required parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/0/issues/0" with body:
    """
      {
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "title": [
          "This value should not be blank."
        ],
        "type": [
          "This value should not be blank."
        ],
        "priority": [
          "This value should not be blank."
        ]
      }
    """

  Scenario: Updating the 1 issue with user which is participant
    Given I am authenticating with "access-token-2" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/1/issues/0" with body:
    """
      {
        "title": "Updated issue",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Updating the 1 issue with user which is assignee
    Given I am authenticating with "access-token-3" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/1/issues/2" with body:
    """
      {
        "title": "Updated issue 0",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "2",
        "assignee": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "comments": [],
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "The description",
        "labels": [],
        "priority": 0,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "id": "2",
          "color": "#f1c40f"
        },
        "title": "Updated issue 0",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/1/issues/2"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/1"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/2/issues"
          }
        }
      }
    """

  Scenario: Updating the 1 issue with user which is reporter
    Given I am authenticating with "access-token-3" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/1/issues/3" with body:
    """
      {
        "title": "Updated issue 1",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "3",
        "assignee": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "comments": [],
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "The description",
        "labels": [],
        "priority": 0,
        "reporter": {
          "id": "3",
          "email": "user4@kreta.com",
          "first_name": "Kreta",
          "last_name": "User4"
        },
        "status": {
          "id": "2",
          "color": "#f1c40f"
        },
        "title": "Updated issue 1",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/1/issues/3"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/1"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/3/issues"
          }
        }
      }
    """

  Scenario: Updating the 1 issue with user which is admin
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/0/issues/0" with body:
    """
      {
        "title": "Updated issue 2",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "assignee": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "comments": [],
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "The description",
        "labels": [],
        "priority": 0,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "id": "0",
          "color": "#27ae60"
        },
        "title": "Updated issue 2",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      } 
    """
