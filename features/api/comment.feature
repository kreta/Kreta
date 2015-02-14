# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@api
Feature: Manage comment
  In order to manage comments
  As an API comment
  I want to be able to GET, POST and PUT comments

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
      | id | numericId | project        | title        | description | reporter       | assignee       | type | status   | priority | createdAt  |
      | 0  | 1         | Test project 1 | Test issue 1 | Description | user@kreta.com | user@kreta.com | 4    | Open     | 1        | 2014-12-15 |
      | 1  | 2         | Test project 1 | Test issue 2 | Description | user@kreta.com | user@kreta.com | 2    | Resolved | 1        | 2014-11-07 |
    And the following comments exist:
      | id | description        | user            | issue        | createdAt  | updatedAt  |
      | 0  | The description 1  | user@kreta.com  | Test issue 1 | 2015-01-10 | 2015-03-01 |
      | 1  | The description 2  | user@kreta.com  | Test issue 2 | 2015-01-15 | 2015-03-01 |
      | 2  | The description 3  | user@kreta.com  | Test issue 1 | 2015-01-31 | 2015-02-01 |
      | 3  | The description 4  | user@kreta.com  | Test issue 1 | 2015-01-09 | 2015-02-21 |
      | 4  | The description 5  | user@kreta.com  | Test issue 1 | 2015-01-20 | 2015-01-30 |
      | 5  | The description 6  | user2@kreta.com | Test issue 1 | 2015-02-09 | 2015-02-10 |
      | 6  | The description 7  | user2@kreta.com | Test issue 2 | 2015-02-01 | 2015-02-01 |
      | 7  | The description 8  | user3@kreta.com | Test issue 1 | 2015-01-02 | 2015-01-24 |
      | 8  | The description 9  | user4@kreta.com | Test issue 1 | 2015-01-09 | 2015-02-18 |
      | 9  | The description 10 | user3@kreta.com | Test issue 1 | 2015-02-07 | 2015-02-18 |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |
      | access-token-3 | null      | user  | user4@kreta.com |

  Scenario: Getting all the comments of issue 0
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0/comments"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "created_at": "2015-01-02T00:00:00+0100",
        "description": "The description 8",
        "updated_at": "2015-01-24T00:00:00+0100",
        "written_by": {
          "first_name": "Kreta",
          "last_name": "User3"
        },
        "_links": {
          "issue": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at": "2015-01-09T00:00:00+0100",
        "description": "The description 4",
        "updated_at": "2015-02-21T00:00:00+0100",
        "written_by": {
          "first_name": "Kreta",
          "last_name": "User"
        },
        "_links": {
          "issue": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at": "2015-01-09T00:00:00+0100",
        "description": "The description 9",
        "updated_at": "2015-02-18T00:00:00+0100",
        "written_by": {
          "first_name": "Kreta",
          "last_name": "User4"
        },
        "_links": {
          "issue": {
              "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at": "2015-01-10T00:00:00+0100",
        "description": "The description 1",
        "updated_at": "2015-03-01T00:00:00+0100",
        "written_by": {
          "first_name": "Kreta",
          "last_name": "User"
        },
        "_links": {
          "issue": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at": "2015-01-20T00:00:00+0100",
        "description": "The description 5",
        "updated_at": "2015-01-30T00:00:00+0100",
        "written_by": {
          "first_name": "Kreta",
          "last_name": "User"
        },
        "_links": {
          "issue": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at": "2015-01-31T00:00:00+0100",
        "description": "The description 3",
        "updated_at": "2015-02-01T00:00:00+0100",
        "written_by": {
          "first_name": "Kreta",
          "last_name": "User"
        },
        "_links": {
          "issue": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at": "2015-02-07T00:00:00+0100",
        "description": "The description 10",
        "updated_at": "2015-02-18T00:00:00+0100",
        "written_by": {
          "first_name": "Kreta",
          "last_name": "User3"
        },
        "_links": {
          "issue": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at": "2015-02-09T00:00:00+0100",
        "description": "The description 6",
        "updated_at": "2015-02-10T00:00:00+0100",
        "written_by": {
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "_links": {
          "issue": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }]
    """

  Scenario: Getting all the comments of issue 0 that the writer is user@kreta.com
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0/comments?owner=user@kreta.com"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "created_at":"2015-01-09T00:00:00+0100",
        "description":"The description 4",
        "updated_at":"2015-02-21T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at":"2015-01-10T00:00:00+0100",
        "description":"The description 1",
        "updated_at":"2015-03-01T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at":"2015-01-20T00:00:00+0100",
        "description":"The description 5",
        "updated_at":"2015-01-30T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at":"2015-01-31T00:00:00+0100",
        "description":"The description 3",
        "updated_at":"2015-02-01T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }]
    """

  Scenario: Getting all the comments of issue 0 from 2015-01-10
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0/comments?createdAt=2015-01-10"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "created_at":"2015-01-10T00:00:00+0100",
        "description":"The description 1",
        "updated_at":"2015-03-01T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at":"2015-01-20T00:00:00+0100",
        "description":"The description 5",
        "updated_at":"2015-01-30T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at":"2015-01-31T00:00:00+0100",
        "description":"The description 3",
        "updated_at":"2015-02-01T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at":"2015-02-07T00:00:00+0100",
        "description":"The description 10",
        "updated_at":"2015-02-18T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User3"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at":"2015-02-09T00:00:00+0100",
        "description":"The description 6",
        "updated_at":"2015-02-10T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User2"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }]
    """

  Scenario: Getting all the comments issue 0 with limit 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0/comments?limit=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "created_at":"2015-01-02T00:00:00+0100",
        "description":"The description 8",
        "updated_at":"2015-01-24T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User3"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at":"2015-01-09T00:00:00+0100",
        "description":"The description 4",
        "updated_at":"2015-02-21T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }]
    """

  Scenario: Getting all the comments issue 0 with offset 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0/comments?offset=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "created_at":"2015-01-09T00:00:00+0100",
        "description":"The description 9",
        "updated_at":"2015-02-18T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User4"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at":"2015-01-10T00:00:00+0100",
        "description":"The description 1",
        "updated_at":"2015-03-01T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at":"2015-01-20T00:00:00+0100",
        "description":"The description 5",
        "updated_at":"2015-01-30T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at":"2015-01-31T00:00:00+0100",
        "description":"The description 3",
        "updated_at":"2015-02-01T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at":"2015-02-07T00:00:00+0100",
        "description":"The description 10",
        "updated_at":"2015-02-18T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User3"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }, {
        "created_at":"2015-02-09T00:00:00+0100",
        "description":"The description 6",
        "updated_at":"2015-02-10T00:00:00+0100",
        "written_by":{
          "first_name":"Kreta",
          "last_name":"User2"
        },
        "_links":{
          "issue":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "comments":{
            "href":"http://localhost/app_test.php/api/projects/0/issues/0/comments"
          }
        }
      }]
    """

  Scenario: Getting all the comments of issue 0 with user which is not a project participant
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0/comments"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting all the comments of project unknown project
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/unknown-project/issues/0/comments"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting all the comments of issue unknown issue
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/unknown-issue/comments"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Creating a comment
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/issues/0/comments" with body:
    """
      {
        "description": "The comment description"
      }
    """
    Then the response code should be 201

  Scenario: Creating a comment without description
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/issues/0/comments" with body:
    """
      {
        "description": ""
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "description": [
          "This value should not be blank."
        ]
      }
    """

  Scenario: Creating a comment of issue 0 with user which is not a project participant
    Given I am authenticating with "access-token-3" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/issues/0/comments" with body:
    """
      {
        "description": "The comment description"
      }
    """
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Creating a comment of issue 0 of project unknown project
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/unknown-project/issues/0/comments" with body:
    """
      {
        "description": "The comment description"
      }
    """
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Creating a comment of issue unknown issue
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/issues/unknown-issue/comments" with body:
    """
      {
        "description": "The comment description"
      }
    """
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """
