# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@vcs
Feature: Manage vcs repository
  In order to manage vcs repositories
  As an API project
  I want to be able to GET vcs repositories

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
    And the following repositories exist:
      | id | name                | provider | url                                    | projects |
      | 0  | kreta-io/kreta      | github   | https://github.com/kreta-io/kreta      | 0,1      |
      | 1  | kreta-io/CoreBundle | github   | https://github.com/kreta-io/CoreBundle | 0        |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |
      | access-token-3 | null      | user  | user4@kreta.com |

  Scenario: Getting all the vcs repositories of project 0
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/vcs-repositories"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "0",
        "name": "kreta-io/kreta",
        "provider": "github",
        "_links": {
          "repositories": {
            "href": "http://localhost/app_test.php/api/projects/0/vcs-repositories"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }, {
        "id": "1",
        "name": "kreta-io/CoreBundle",
        "provider": "github",
        "_links": {
          "repositories": {
            "href": "http://localhost/app_test.php/api/projects/0/vcs-repositories"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          }
        }
      }]
    """

  Scenario: Getting all the vcs repositories of project 1
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/1/vcs-repositories"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "0",
        "name": "kreta-io/kreta",
        "provider": "github",
        "_links": {
          "repositories": {
            "href": "http://localhost/app_test.php/api/projects/1/vcs-repositories"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/1"
          }
        }
      }]
    """

  Scenario: Getting all the vcs repositories with user which is not a project participant
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/app_test.php/api/projects/0/vcs-repositories"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting all the vcs repositories of unknown project
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/unknown-project/vcs-repositories"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """
