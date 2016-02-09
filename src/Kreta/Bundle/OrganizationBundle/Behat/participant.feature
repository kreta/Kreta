# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

@organizationParticipant
Feature: Manage organization participant
  In order to manage organization participants
  As an API organization participant
  I want to be able to GET, POST and DELETE organization participants

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
      | 1  | Test organization 2 | user@kreta.com |
    And the following medias exist:
      | id | name               | createdAt  | updatedAt | resource            |
      | 0  | organization-1.jpg | 2014-10-30 | null      | Test organization 1 |
      | 1  | organization-2.jpg | 2014-10-30 | null      | Test organization 2 |
      | 2  | user-2.jpg         | 2014-10-30 | null      | user2@kreta.com     |
      | 3  | user-3.jpg         | 2014-10-30 | null      | user3@kreta.com     |
    And the following organization participants exist:
      | organization        | user            | role                 |
      | Test organization 1 | user2@kreta.com | ROLE_ORG_PARTICIPANT |
      | Test organization 2 | user2@kreta.com | ROLE_ORG_PARTICIPANT |
      | Test organization 2 | user4@kreta.com | ROLE_ORG_PARTICIPANT |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |
      | access-token-3 | null      | user  | user4@kreta.com |

  Scenario: Getting all the participants of organization 0
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/organizations/0/participants"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "organization": {
            "id": "0",
            "name": "Test organization 1",
            "slug": "test-organization-1"
          },
          "role": "ROLE_ORG_ADMIN",
          "user": {
            "id": "0",
            "username": "user",
            "email": "user@kreta.com",
            "first_name": "Kreta",
            "last_name": "User",
            "photo": null
          },
          "_links": {
            "participants": {
              "href": "http://kreta.test:8000/api/organizations/0/participants"
            },
            "organization": {
              "href": "http://kreta.test:8000/api/organizations/0"
            },
            "organizations": {
              "href": "http://kreta.test:8000/api/organizations"
            },
            "projects": {
              "href": "http://kreta.test:8000/api/projects"
            }
          }
        },
        {
          "organization": {
            "id": "0",
            "name": "Test organization 1",
            "slug": "test-organization-1"
          },
          "role": "ROLE_ORG_PARTICIPANT",
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
              "href": "http://kreta.test:8000/api/organizations/0/participants"
            },
            "organization": {
              "href": "http://kreta.test:8000/api/organizations/0"
            },
            "organizations": {
              "href": "http://kreta.test:8000/api/organizations"
            },
            "projects": {
              "href": "http://kreta.test:8000/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the participants of organization 0 with user which is not a organization participant
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/api/organizations/0/participants"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting all the participants of organization unknown organization
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/api/organizations/unknown-organization/participants"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting all the participants of organization 0 filter by name=user@kreta.com
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/organizations/0/participants?q=user@kreta.com"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "organization": {
            "id": "0",
            "name": "Test organization 1",
            "slug": "test-organization-1"
          },
          "role": "ROLE_ORG_ADMIN",
          "user": {
            "id": "0",
            "username": "user",
            "email": "user@kreta.com",
            "first_name": "Kreta",
            "last_name": "User",
            "photo": null
          },
          "_links": {
            "participants": {
              "href": "http://kreta.test:8000/api/organizations/0/participants"
            },
            "organization": {
              "href": "http://kreta.test:8000/api/organizations/0"
            },
            "organizations": {
              "href": "http://kreta.test:8000/api/organizations"
            },
            "projects": {
              "href": "http://kreta.test:8000/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the participants of organization 0 with limit 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/organizations/0/participants?limit=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "organization": {
            "id": "0",
            "name": "Test organization 1",
            "slug": "test-organization-1"
          },
          "role": "ROLE_ORG_ADMIN",
          "user": {
            "id": "0",
            "username": "user",
            "email": "user@kreta.com",
            "first_name": "Kreta",
            "last_name": "User",
            "photo": null
          },
          "_links": {
            "participants": {
              "href": "http://kreta.test:8000/api/organizations/0/participants"
            },
            "organization": {
              "href": "http://kreta.test:8000/api/organizations/0"
            },
            "organizations": {
              "href": "http://kreta.test:8000/api/organizations"
            },
            "projects": {
              "href": "http://kreta.test:8000/api/projects"
            }
          }
        },
        {
          "organization": {
            "id": "0",
            "name": "Test organization 1",
            "slug": "test-organization-1"
          },
          "role": "ROLE_ORG_PARTICIPANT",
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
              "href": "http://kreta.test:8000/api/organizations/0/participants"
            },
            "organization": {
              "href": "http://kreta.test:8000/api/organizations/0"
            },
            "organizations": {
              "href": "http://kreta.test:8000/api/organizations"
            },
            "projects": {
              "href": "http://kreta.test:8000/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the participants of organization 1 with offset 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/organizations/1/participants?offset=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "organization": {
            "id": "1",
            "name": "Test organization 2",
            "slug": "test-organization-2"
          },
          "role": "ROLE_ORG_PARTICIPANT",
          "user": {
            "id": "3",
            "username": "user4",
            "email": "user4@kreta.com",
            "first_name": "Kreta",
            "last_name": "User4",
            "photo": null
          },
          "_links": {
            "participants": {
              "href": "http://kreta.test:8000/api/organizations/1/participants"
            },
            "organization": {
              "href": "http://kreta.test:8000/api/organizations/1"
            },
            "organizations": {
              "href": "http://kreta.test:8000/api/organizations"
            },
            "projects": {
              "href": "http://kreta.test:8000/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Creating a participant with user that does not have required grant
    Given I am authenticating with "access-token-3" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/organizations/0/participants" with body:
    """
      {
        "role": "ROLE_ORG_ADMIN",
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
    When I send a POST request to "/api/organizations/0/participants" with body:
    """
      {
        "role": "ROLE_ORG_ADMIN",
        "user": "2"
      }
    """
    Then the response code should be 201
    And the response should contain json:
    """
      {
        "organization": {
          "id": "0",
          "name": "Test organization 1",
          "slug": "test-organization-1"
        },
        "role": "ROLE_ORG_ADMIN",
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
            "href": "http://kreta.test:8000/api/organizations/0/participants"
          },
          "organization": {
            "href": "http://kreta.test:8000/api/organizations/0"
          },
          "organizations": {
            "href": "http://kreta.test:8000/api/organizations"
          },
          "projects": {
            "href": "http://kreta.test:8000/api/projects"
          }
        }
      }
    """

  Scenario: Creating a participant that is already organization participant
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/organizations/0/participants" with body:
    """
      {
        "role": "ROLE_ORG_ADMIN",
        "user": "1"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "user": [
          "This participant is already exists in this organization"
        ]
      }
    """

  Scenario: Creating a participant in unknown organization
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/organizations/unknown-organization/participants" with body:
    """
      {
        "role": "ROLE_ORG_ADMIN",
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
    When I send a POST request to "/api/organizations/1/participants" with body:
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
    When I send a POST request to "/api/organizations/1/participants" with body:
    """
      {
        "role": "ROLE_ORG_ADMIN"
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

  Scenario: Deleting participant 0 of organization 0
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/api/organizations/0/participants/0"
    Then the response code should be 204

  Scenario: Deleting participant 0 with user which is not a organization admin
    Given I am authenticating with "access-token-3" token
    When I send a DELETE request to "/api/organizations/0/participants/0"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Deleting participant 0 of unknown organization
    Given I am authenticating with "access-token-0" token
    When I send a DELETE request to "/api/projects/unknown-organization/participants/0"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """
