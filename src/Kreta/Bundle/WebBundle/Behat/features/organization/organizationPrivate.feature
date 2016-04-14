# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

@organizationPrivate
Feature: Manage organizations
  In order to manage organizations
  As an API private organization
  I want to be able to GET organizations

  Background:
    Given the following users exist:
      | id | firstName | lastName | username | email           | password | createdAt  |
      | 0  | Kreta     | User     | user     | user@kreta.com  | 123456   | 2014-10-20 |
      | 1  | Kreta     | User2    | user2    | user2@kreta.com | 123456   | 2014-10-20 |
      | 2  | Kreta     | User3    | user3    | user3@kreta.com | 123456   | 2014-10-20 |
    And the following organizations exist:
      | id | name                | creator        |
      | 0  | Test organization 1 | user@kreta.com |
      | 1  | Test organization 2 | user@kreta.com |
    And the following workflows exist:
      | id | name       | creator        |
      | 0  | Workflow 1 | user@kreta.com |
      | 1  | Workflow 2 | user@kreta.com |
    And the following projects exist:
      | id | name           | creator        | workflow   | organization        |
      | 0  | Test project 1 | user@kreta.com | Workflow 1 | Test organization 1 |
      | 1  | Test project 2 | user@kreta.com | Workflow 2 | Test organization 1 |
    And the following issue priorities exist:
      | id | name    | color   | project        |
      | 0  | Low     | #969696 | Test project 1 |
      | 1  | Medium  | #67b86a | Test project 1 |
      | 2  | High    | #f07f2c | Test project 1 |
      | 3  | Blocker | #f02c4c | Test project 1 |
      | 4  | Low     | #969696 | Test project 2 |
      | 5  | Medium  | #67b86a | Test project 2 |
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
    And the following medias exist:
      | id | name               | createdAt  | updatedAt | resource            |
      | 0  | organization-1.jpg | 2014-10-30 | null      | Test organization 1 |
      | 1  | organization-2.jpg | 2014-10-30 | null      | Test organization 2 |
      | 2  | user-2.jpg         | 2014-10-30 | null      | user2@kreta.com     |
      | 3  | user-3.jpg         | 2014-10-30 | null      | user3@kreta.com     |
    And the following organization participants exist:
      | organization        | user            | role                 |
      | Test organization 1 | user3@kreta.com | ROLE_ORG_PARTICIPANT |
      | Test organization 2 | user2@kreta.com | ROLE_ORG_PARTICIPANT |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |

  Scenario: Getting the organization of test-organization-1
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/private/organizations/test-organization-1"
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "image": {
          "id": "0",
          "created_at": "2014-10-30T00:00:00+0100",
          "name": "http://kreta.test:8000/media/image/organization-1.jpg",
          "updated_at": null
        },
        "name": "Test organization 1",
        "participants": [
          {
            "role": "ROLE_ORG_ADMIN",
            "user": {
              "id": "0",
              "username": "user",
              "email": "user@kreta.com",
              "created_at": "2014-10-20T00:00:00+0200",
              "first_name": "Kreta",
              "last_name": "User",
              "photo": null
            }
          },
          {
            "role": "ROLE_ORG_PARTICIPANT",
            "user": {
              "id": "2",
              "username": "user3",
              "email": "user3@kreta.com",
              "created_at": "2014-10-20T00:00:00+0200",
              "first_name": "Kreta",
              "last_name": "User3",
              "photo": {
                "id": "3",
                "created_at": "2014-10-30T00:00:00+0100",
                "name": "http://kreta.test:8000/media/image/user-3.jpg",
                "updated_at": null
              }
            }
          }
        ],
        "slug": "test-organization-1"
      }
    """

  Scenario: Getting the unknown organization
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/private/organizations/unknown-organization"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error":"Does not exist any object with id passed"
      }
    """
