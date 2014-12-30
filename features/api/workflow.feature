# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@api-o
Feature: Manage workflow
  In order to manage workflows
  As an API workflow
  I want to be able to GET, POST, PUT workflows

  Background:
    Given the following users exist:
      | id | firstName | lastName | email           | password | createdAt  |
      | 0  | Kreta     | User     | user@kreta.com  | 123456   | 2013-10-20 |
      | 1  | Kreta     | User2    | user2@kreta.com | 123456   | 2013-10-20 |
      | 2  | Kreta     | User3    | user3@kreta.com | 123456   | 2013-10-20 |
    And the following workflows exist:
      | id | name       | creator         | createdAt  |
      | 0  | Workflow 1 | user@kreta.com  | 2014-11-29 |
      | 1  | Workflow 2 | user@kreta.com  | 2014-11-30 |
      | 2  | Workflow 3 | user2@kreta.com | 2014-11-20 |
      | 3  | Workflow 4 | user@kreta.com  | 2014-12-30 |
      | 4  | Workflow 5 | user@kreta.com  | 2014-09-17 |
      | 5  | Workflow 6 | user@kreta.com  | 2014-10-20 |
    And the following projects exist:
      | id | name           | shortName | creator        | workflow   |
      | 0  | Test project 1 | TPR1      | user@kreta.com | Workflow 1 |
      | 1  | Test project 2 | TPR2      | user@kreta.com | Workflow 2 |
    And the following statuses exist:
      | id | color   | name        | workflow   |
      | 0  | #27ae60 | Open        | Workflow 1 |
      | 1  | #2c3e50 | In progress | Workflow 1 |
      | 2  | #f1c40f | Resolved    | Workflow 1 |
    And the following participants exist:
      | project        | user            | role             |
      | Test project 1 | user3@kreta.com | ROLE_PARTICIPANT |
      | Test project 1 | user2@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user2@kreta.com | ROLE_PARTICIPANT |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |

  Scenario: Getting all the workflows that can see user@kreta.com
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "0",
        "created_at": "2014-11-29T00:00:00+0100",
        "name": "Workflow 1",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/0"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/0/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/0/statuses"
          }
        }
      }, {
        "id": "1",
        "created_at": "2014-11-30T00:00:00+0100",
        "name": "Workflow 2",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/1"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/1/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/1/statuses"
          }
        }
      }, {
        "id": "3",
        "created_at": "2014-12-30T00:00:00+0100",
        "name": "Workflow 4",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/3"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/3/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/3/statuses"
          }
        }
      }, {
        "id": "4",
        "created_at": "2014-09-17T00:00:00+0200",
        "name": "Workflow 5",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/4"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/4/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/4/statuses"
          }
        }
      }, {
        "id": "5",
        "created_at": "2014-10-20T00:00:00+0200",
        "name": "Workflow 6",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/5"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/5/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/5/statuses"
          }
        }
      }]
    """

  Scenario: Getting all the workflows that can see user2@kreta.com
    Given I am authenticating with "access-token-1" token
    When I send a GET request to "/app_test.php/api/workflows"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "2",
        "created_at": "2014-11-20T00:00:00+0100",
        "name": "Workflow 3",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/2"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/2/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/2/statuses"
          }
        }
      }]
    """

  Scenario: Getting all the workflows that can see user@kreta.com with limit 3
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows?limit=3"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "0",
        "created_at": "2014-11-29T00:00:00+0100",
        "name": "Workflow 1",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/0"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/0/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/0/statuses"
          }
        }
      }, {
        "id": "1",
        "created_at": "2014-11-30T00:00:00+0100",
        "name": "Workflow 2",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/1"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/1/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/1/statuses"
          }
        }
      }, {
        "id": "3",
        "created_at": "2014-12-30T00:00:00+0100",
        "name": "Workflow 4",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/3"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/3/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/3/statuses"
          }
        }
      }]
    """

  Scenario: Getting all the workflows that can see user@kreta.com with offset 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows?offset=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "3",
        "created_at": "2014-12-30T00:00:00+0100",
        "name": "Workflow 4",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/3"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/3/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/3/statuses"
          }
        }
      }, {
        "id": "4",
        "created_at": "2014-09-17T00:00:00+0200",
        "name": "Workflow 5",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/4"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/4/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/4/statuses"
          }
        }
      }, {
        "id": "5",
        "created_at": "2014-10-20T00:00:00+0200",
        "name": "Workflow 6",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/5"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/5/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/5/statuses"
          }
        }
      }]
    """

  Scenario: Getting all the workflows that can see user@kreta.com sort by createdAt
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows?sort=createdAt"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "4",
        "created_at": "2014-09-17T00:00:00+0200",
        "name": "Workflow 5",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/4"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/4/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/4/statuses"
          }
        }
      }, {
        "id": "5",
        "created_at": "2014-10-20T00:00:00+0200",
        "name": "Workflow 6",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/5"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/5/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/5/statuses"
          }
        }
      }, {
        "id": "0",
        "created_at": "2014-11-29T00:00:00+0100",
        "name": "Workflow 1",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/0"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/0/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/0/statuses"
          }
        }
      }, {
        "id": "1",
        "created_at": "2014-11-30T00:00:00+0100",
        "name": "Workflow 2",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/1"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/1/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/1/statuses"
          }
        }
      }, {
        "id": "3",
        "created_at": "2014-12-30T00:00:00+0100",
        "name": "Workflow 4",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/3"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/3/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/3/statuses"
          }
        }
      }]
    """

  Scenario: Getting all the workflows that can see user@kreta.com sort by createdAt with limit 3 and offset 1
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows?sort=createdAt&limit=3&offset=1"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "5",
        "created_at": "2014-10-20T00:00:00+0200",
        "name": "Workflow 6",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/5"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/5/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/5/statuses"
          }
        }
      }, {
        "id": "0",
        "created_at": "2014-11-29T00:00:00+0100",
        "name": "Workflow 1",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/0"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/0/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/0/statuses"
          }
        }
      }, {
        "id": "1",
        "created_at": "2014-11-30T00:00:00+0100",
        "name": "Workflow 2",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/1"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/1/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/1/statuses"
          }
        }
      }]
    """

  Scenario: Getting the 0 workflow
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/0"
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "created_at": "2014-11-29T00:00:00+0100",
        "name": "Workflow 1",
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/workflows/0"
          },
          "workflows": {
            "href": "http://localhost/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://localhost/app_test.php/api/workflows/0/transitions"
          },
          "statuses": {
            "href": "http://localhost/app_test.php/api/workflows/0/statuses"
          }
        }
      }
    """

  Scenario: Getting the unknown workflow
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/workflows/unknown-workflow"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any entity with unknown-workflow id"
      }
    """

  Scenario: Getting the 2 workflow with the user that is not its project participant
    Given I am authenticating with "access-token-1" token
    When I send a GET request to "/app_test.php/api/workflows/2"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """
