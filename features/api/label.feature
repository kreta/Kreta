# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@api
Feature: Manage label
  In order to manage labels
  As an API label
  I want to be able to GET, POST and DELETE labels

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
    And the following labels exist:
      | id | name        | project        |
      | 0  | backbone.js | Test project 1 |
      | 1  | php         | Test project 2 |
      | 2  | javascript  | Test project 1 |
      | 3  | bdd         | Test project 1 |
      | 4  | behat       | Test project 2 |
      | 5  | phpspec     | Test project 2 |
      | 6  | symfony     | Test project 1 |
      | 7  | html5       | Test project 2 |
      | 8  | css3        | Test project 1 |
      | 9  | sass        | Test project 1 |
      | 10 | compass     | Test project 2 |
      | 11 | mysql       | Test project 1 |
      | 12 | mongodb     | Test project 1 |
      | 13 | java        | Test project 1 |
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

  Scenario: Getting all the labels of project 0
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/labels"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "0",
        "name": "backbone.js",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "3",
        "name": "bdd",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "8",
        "name": "css3",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "13",
        "name": "java",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "2",
        "name": "javascript",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "12",
        "name": "mongodb",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project":{
            "href":"http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "11",
        "name": "mysql",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "9",
        "name": "sass",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "6",
        "name": "symfony",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }]
    """

  Scenario: Getting all the labels of project 0 with user which is not a project participant
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/app_test.php/api/projects/0/labels"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting all the labels of project unknown project
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/app_test.php/api/projects/unknown-project/labels"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting all the labels of project 0 filter by name=java
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/labels?q=java"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "13",
        "name": "java",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "2",
        "name": "javascript",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }]
    """

  Scenario: Getting all the labels of project 0 with limit 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/labels?limit=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "0",
        "name": "backbone.js",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "3",
        "name": "bdd",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }]
    """

  Scenario: Getting all the labels of project 0 with offset 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/labels?offset=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "8",
        "name": "css3",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "13",
        "name": "java",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "2",
        "name": "javascript",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "12",
        "name": "mongodb",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project":{
            "href":"http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "11",
        "name": "mysql",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "9",
        "name": "sass",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "6",
        "name": "symfony",
        "_links": {
          "labels": {
            "href": "http://localhost/app_test.php/api/projects/0/labels"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }]
    """

  Scenario: Creating a label
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/labels" with body:
    """
      {
        "name": "New label"
      }
    """
    Then the response code should be 201

  Scenario: Creating a label with user which is not a project participant
    Given I am authenticating with "access-token-3" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/labels" with body:
    """
      {
        "name": "New label"
      }
    """
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Creating a label in unknown project
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/unknown-project/labels" with body:
    """
      {
        "name": "New label"
      }
    """
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Creating a label without name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/1/labels" with body:
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

  Scenario: Creating a label with already exists name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/1/labels" with body:
    """
      {
        "name": "php"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "name": [
          "A label with identical name is already exists in this project"
        ]
      } 
    """

  Scenario: Deleting label 0 of project 0
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/projects/0/labels/0"
    Then the response code should be 204

  Scenario: Deleting label 0 with user which is not a project admin
    Given I am authenticating with "access-token-3" token
    When I send a DELETE request to "/app_test.php/api/projects/0/labels/0"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      } 
    """

  Scenario: Deleting label 0 of unknown project
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/app_test.php/api/projects/unknown-project/labels/0"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      } 
    """
