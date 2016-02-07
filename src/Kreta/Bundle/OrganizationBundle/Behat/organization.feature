# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

@organization
Feature: Manage organizations
  In order to manage organizations
  As an API organization
  I want to be able to GET, POST and PUT organizations

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

  Scenario: Getting all the organizations
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/organizations"
    Then the response code should be 200
    And print response
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "image": {
            "id": "0",
            "name": "http://kreta.test:8000/media/image/organization-1.jpg"
          },
          "name": "Test organization 1",
          "participants": [
            {
              "organization": null,
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
              "organization": null,
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
                  "name": "http://kreta.test:8000/media/image/user-3.jpg"
                }
              }
            }
          ],
          "_links": {
            "self": {
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
          "id": "1",
          "image": {
            "id": "1",
            "name": "http://kreta.test:8000/media/image/organization-2.jpg"
          },
          "name": "Test organization 2",
          "participants": [
            {
              "organization": null,
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
              "organization": null,
              "role": "ROLE_ORG_PARTICIPANT",
              "user": {
                "id": "1",
                "username": "user2",
                "email": "user2@kreta.com",
                "created_at": "2014-10-20T00:00:00+0200",
                "first_name": "Kreta",
                "last_name": "User2",
                "photo": {
                  "id": "2",
                  "name": "http://kreta.test:8000/media/image/user-2.jpg"
                }
              }
            }
          ],
          "_links": {
            "self": {
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

  Scenario: Getting the 0 organization
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/organizations/0"
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
            "organization": null,
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
            "organization": null,
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
        "_links": {
          "self": {
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

  Scenario: Getting the unknown organization
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/organizations/unknown-organization"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting the organization that the user is not allowed
    Given I am authenticating with "access-token-1" token
    When I send a GET request to "/api/organizations/0"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Creating a organization
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/organizations" with body:
    """
      {
        "name": "New organization"
      }
    """
    Then the response code should be 201

  Scenario: Creating a organization with existing name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/organizations" with body:
    """
      {
        "name": "Test organization 1"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "name": [
          "Name is already in use"
        ]
      }
    """

  Scenario: Creating a organization without parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/organizations" with body:
    """
      {
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "name":[],
        "image": []
      }
    """

  Scenario: Creating a organization with the missing required parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/organizations" with body:
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
        ]
      }
    """

  Scenario: Updating the 0 organization
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/api/organizations/0" with body:
    """
      {
        "name": "Updated organization name"
      }
    """
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
        "name": "Updated organization name",
        "participants": [
          {
            "organization": null,
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
            "organization": null,
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
        "links": {
          "self": {
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

  Scenario: Updating the 0 organization with the missing required parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/api/organizations/0" with body:
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
        ]
      }
    """
