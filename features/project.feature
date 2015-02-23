# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@project
Feature: Manage projects
  In order to manage projects
  As an API project
  I want to be able to GET, POST and PUT projects

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
    And the following participants exist:
      | project        | user            | role             |
      | Test project 1 | user3@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user2@kreta.com | ROLE_PARTICIPANT |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |

  Scenario: Getting all the project
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "0",
        "name": "Test project 1",
        "participants": [{
          "role": "ROLE_ADMIN",
          "user": {
            "id": "0",
            "email": "user@kreta.com",
            "created_at": "2014-10-20T00:00:00+0200",
            "first_name": "Kreta",
            "last_name": "User"
          }
        }],
        "short_name": "TPR1",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "projects": {
            "href": "http://localhost/app_test.php/api/projects"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/0/statuses"
          },
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          }
        }
      }, {
        "id": "1",
        "name": "Test project 2",
        "participants": [{
          "role": "ROLE_ADMIN",
          "user": {
            "id": "0",
            "email": "user@kreta.com",
            "created_at": "2014-10-20T00:00:00+0200",
            "first_name": "Kreta",
            "last_name": "User"
          }
        }],
        "short_name": "TPR2",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/1"
          },
          "projects": {
            "href": "http://localhost/app_test.php/api/projects"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/1/issues"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/1/statuses"
          },
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/1/labels"
          }
        }
      }]
    """

  Scenario: Getting the 0 project
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0"
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "name": "Test project 1",
        "participants": [{
          "role": "ROLE_ADMIN",
          "user": {
            "id": "0",
            "email": "user@kreta.com",
            "created_at": "2014-10-20T00:00:00+0200",
            "first_name": "Kreta",
            "last_name": "User"
          }
        }, {
          "role": "ROLE_PARTICIPANT",
          "user": {
            "id": "2",
            "email": "user3@kreta.com",
            "created_at": "2014-10-20T00:00:00+0200",
            "first_name": "Kreta",
            "last_name": "User3"
          }
        }],
        "short_name": "TPR1",
        "workflow": {
          "id": "0",
          "name": "Workflow 1"
        },
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "projects": {
            "href": "http://localhost/app_test.php/api/projects"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/0/statuses"
          },
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          }
        }
      }
    """

  Scenario: Getting the unknown project
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/unknown-project"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting the project that the user is not allowed
    Given I am authenticating with "access-token-1" token
    When I send a GET request to "/app_test.php/api/projects/0"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Creating a project
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects" with body:
    """
      {
        "name": "New project",
        "shortName": "NPR"
      }
    """
    Then the response code should be 201
    And the response should contain json:
    """
      {
        "name": "New project",
        "participants": [{
          "role": "ROLE_ADMIN",
          "user": {
            "id": "0",
            "email": "user@kreta.com",
            "created_at": "2014-10-20T00:00:00+0200",
            "first_name": "Kreta",
            "last_name": "User"
          }
        }, {
          "role": "ROLE_ADMIN",
          "user": {
            "id": "0",
            "email": "user@kreta.com",
            "created_at": "2014-10-20T00:00:00+0200",
            "first_name": "Kreta",
            "last_name": "User"
          }
        }],
        "short_name": "NPR"
      }
    """

  Scenario: Creating a project with workflow
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects" with body:
    """
      {
        "name": "New project",
        "shortName": "NPR2",
        "workflow": "0"
      }
    """
    Then the response code should be 201
    And the response should contain json:
    """
      {
        "name": "New project",
        "participants": [{
          "role": "ROLE_ADMIN",
          "user": {
            "id": "0",
            "email": "user@kreta.com",
            "created_at": "2014-10-20T00:00:00+0200",
            "first_name": "Kreta",
            "last_name": "User"
          }
        }, {
          "role": "ROLE_ADMIN",
          "user": {
            "id": "0",
            "email": "user@kreta.com",
            "created_at": "2014-10-20T00:00:00+0200",
            "first_name": "Kreta",
            "last_name": "User"
          }
        }],
        "short_name": "NPR2",
        "workflow": {
          "id": "0",
          "name": "Workflow 1"
        }
      }
    """

  Scenario: Creating a project with existing short name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects" with body:
    """
      {
        "name": "New project",
        "shortName": "TPR1"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "shortName": [
          "Short name is already in use"
        ]
      }
    """

  Scenario: Creating a project without parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects" with body:
    """
      {
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "name":[],
        "shortName":[],
        "image": []
      }
    """

  Scenario: Creating a project with the missing required parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects" with body:
    """
      {
        "name": ""
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "name":[
          "This value should not be blank."
        ],
        "shortName":[
          "This value should not be blank."
        ]
      }
    """

  Scenario: Updating the 0 project
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/0" with body:
    """
      {
        "name": "New project",
        "shortName": "NPR",
        "workflow": "0"
      }
    """
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "name": "New project",
        "participants": [{
          "role": "ROLE_ADMIN",
          "user": {
            "id": "0",
            "email": "user@kreta.com",
            "created_at": "2014-10-20T00:00:00+0200",
            "first_name": "Kreta",
            "last_name": "User"
          }
        }, {
          "role": "ROLE_PARTICIPANT",
          "user": {
            "id": "2",
            "email": "user3@kreta.com",
            "created_at": "2014-10-20T00:00:00+0200",
            "first_name": "Kreta",
            "last_name": "User3"
          }
        }],
        "short_name": "NPR",
        "workflow": {
          "id": "0",
          "name": "Workflow 1"
        },
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "projects": {
            "href": "http://localhost/app_test.php/api/projects"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/0/statuses"
          },
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          }
        }
      }
    """

  Scenario: Updating the 0 project with the missing required parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/0" with body:
    """
      {
        "name": "New project"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "shortName":[
          "This value should not be blank."
        ]
      }
    """
