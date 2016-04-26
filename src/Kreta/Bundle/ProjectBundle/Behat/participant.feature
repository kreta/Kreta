# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

@projectParticipant
Feature: Manage project participant
  In order to manage project participants
  As an API project participant
  I want to be able to GET, POST and DELETE project participants

  Background:
    Given the following users exist:
      | id | firstName | lastName | username | email           | password | createdAt  |
      | 0  | Kreta     | User     | user     | user@kreta.com  | 123456   | 2014-10-20 |
      | 1  | Kreta     | User2    | user2    | user2@kreta.com | 123456   | 2014-10-20 |
      | 2  | Kreta     | User3    | user3    | user3@kreta.com | 123456   | 2014-10-20 |
      | 3  | Kreta     | User4    | user4    | user4@kreta.com | 123456   | 2014-10-20 |
    And the following organizations exist:
      | id | name                | creator        |
      | 0  | Test organization 1 | user@kreta.com |
    And the following projects exist:
      | id | name           | creator        | organization        |
      | 0  | Test project 1 | user@kreta.com | Test organization 1 |
      | 1  | Test project 2 | user@kreta.com | Test organization 1 |
    And the following medias exist:
      | id | name          | createdAt  | updatedAt | resource        |
      | 0  | project-1.jpg | 2014-10-30 | null      | Test project 1  |
      | 1  | project-2.jpg | 2014-10-30 | null      | Test project 2  |
      | 2  | user-2.jpg    | 2014-10-30 | null      | user2@kreta.com |
      | 3  | user-3.jpg    | 2014-10-30 | null      | user3@kreta.com |
    And the following participants exist:
      | project        | user            | role             |
      | Test project 1 | user2@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user2@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user4@kreta.com | ROLE_PARTICIPANT |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |
      | access-token-3 | null      | user  | user4@kreta.com |

  Scenario: Getting all the participants of project 0
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/projects/0/participants"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "project": {
            "id": "0",
            "name": "Test project 1",
            "slug": "test-project-1"
          },
          "role": "ROLE_PARTICIPANT",
          "user": {
            "id": "1",
            "username": "user2",
            "email": "user2@kreta.com",
            "first_name": "Kreta",
            "last_name": "User2",
            "photo": {
              "id": "2",
              "name": "http://kreta.test:8000/media/image/user-2.jpg"
            }
          },
          "_links": {
            "participants": {
              "href": "http://kreta.test:8000/api/projects/0/participants"
            },
            "project": {
              "href": "http://kreta.test:8000/api/projects/0"
            },
            "projects": {
              "href": "http://kreta.test:8000/api/projects"
            },
            "issues": {
              "href": "http://kreta.test:8000/api/issues"
            }
          }
        }
      ]
    """

  Scenario: Getting all the participants of project 0 with user which is not a project participant
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/api/projects/0/participants"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting all the participants of project unknown project
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/api/projects/unknown-project/participants"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting all the participants of project 0 filter by name=user@kreta.com
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/projects/0/participants?q=user@kreta.com"
    Then the response code should be 200
    And the response should contain json:
    """
      []
    """

  Scenario: Getting all the participants of project 0 with limit 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/projects/0/participants?limit=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "project": {
            "id": "0",
            "name": "Test project 1",
            "slug": "test-project-1"
          },
          "role": "ROLE_PARTICIPANT",
          "user": {
            "id": "1",
            "username": "user2",
            "email": "user2@kreta.com",
            "first_name": "Kreta",
            "last_name": "User2",
            "photo": {
              "id": "2",
              "name": "http://kreta.test:8000/media/image/user-2.jpg"
            }
          },
          "_links": {
            "participants": {
              "href": "http://kreta.test:8000/api/projects/0/participants"
            },
            "project": {
              "href": "http://kreta.test:8000/api/projects/0"
            },
            "projects": {
              "href": "http://kreta.test:8000/api/projects"
            },
            "issues": {
              "href": "http://kreta.test:8000/api/issues"
            }
          }
        }
      ]
    """

  Scenario: Getting all the participants of project 1 with offset 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/projects/1/participants?offset=2"
    Then the response code should be 200
    And the response should contain json:
    """
      []
    """

  Scenario: Creating a participant with user that does not have required grant
    Given I am authenticating with "access-token-3" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/projects/0/participants" with body:
    """
      {
        "role": "ROLE_ADMIN",
        "user": "1"
      }
    """
    And the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Creating a participant
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/projects/0/participants" with body:
    """
      {
        "role": "ROLE_ADMIN",
        "user": "2"
      }
    """
    Then the response code should be 201
    And the response should contain json:
    """
      {
        "project": {
          "id": "0",
          "name": "Test project 1",
          "slug": "test-project-1"
        },
        "role": "ROLE_ADMIN",
        "user": {
          "id": "2",
          "username": "user3",
          "email": "user3@kreta.com",
          "first_name": "Kreta",
          "last_name": "User3",
          "photo": {
            "id": "3",
            "name": "http://kreta.test:8000/media/image/user-3.jpg"
          }
        },
        "_links": {
          "participants": {
            "href": "http://kreta.test:8000/api/projects/0/participants"
          },
          "project": {
            "href": "http://kreta.test:8000/api/projects/0"
          },
          "projects": {
            "href": "http://kreta.test:8000/api/projects"
          },
          "issues": {
            "href": "http://kreta.test:8000/api/issues"
          }
        }
      }
    """

  Scenario: Creating a participant that is already project participant
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/projects/0/participants" with body:
    """
      {
        "role": "ROLE_ADMIN",
        "user": "1"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "user": [
          "This participant is already exists in this project"
        ]
      }
    """

  Scenario: Creating a participant in unknown project
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/projects/unknown-project/participants" with body:
    """
      {
        "role": "ROLE_ADMIN",
        "user": "0"
      }
    """
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Creating a participant without role
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/projects/1/participants" with body:
    """
      {
        "user": "1"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "role": [
          "This value should not be blank."
        ]
      }
    """

  Scenario: Creating a participant without user
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/projects/1/participants" with body:
    """
      {
        "role": "ROLE_ADMIN"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "user": [
          "This value should not be blank."
        ]
      }
    """

  Scenario: Deleting participant 0 of project 0
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/api/projects/0/participants/1"
    Then the response code should be 204

  Scenario: Deleting participant 0 with user which is not a project admin
    Given I am authenticating with "access-token-3" token
    When I send a DELETE request to "/api/projects/0/participants/1"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Deleting participant 0 of unknown project
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/api/projects/unknown-project/participants/0"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """
