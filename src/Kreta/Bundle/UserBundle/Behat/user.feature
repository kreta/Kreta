# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

@user
Feature: Manage users
  In order to manage users
  As an API user
  I want to be able to GET user

  Background:
    Given the following users exist:
      | id | firstName | lastName | username | email           | password | createdAt  | enabled |
      | 0  | Kreta     | User     | user     | user@kreta.com  | 123456   | 2014-10-20 | 1       |
      | 1  | Kreta     | User2    | user2    | user2@kreta.com | 123456   | 2014-10-20 | 1       |
      | 2  | Kreta     | User3    | user3    | user3@kreta.com | 123456   | 2014-10-20 | 0       |
    And the following medias exist:
      | id | name       | createdAt  | updatedAt | resource        |
      | 1  | user-1.jpg | 2014-10-30 | null      | user@kreta.com  |
      | 2  | user-2.jpg | 2014-10-30 | null      | user2@kreta.com |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |

  Scenario: Getting all the users
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/users"
    And print response
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "username": "user",
          "email": "user@kreta.com",
          "enabled": true,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User",
          "photo": {
            "id": "1",
            "created_at": "2014-10-30T00:00:00+0100",
            "name": "http://kreta.test:8000/media/image/user-1.jpg",
            "updated_at": null
          }
        },
        {
          "id": "1",
          "username": "user2",
          "email": "user2@kreta.com",
          "enabled": true,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User2",
          "photo": {
            "id": "2",
            "created_at": "2014-10-30T00:00:00+0100",
            "name": "http://kreta.test:8000/media/image/user-2.jpg",
            "updated_at": null
          }
        },
        {
          "id": "2",
          "username": "user3",
          "email": "user3@kreta.com",
          "enabled": false,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User3",
          "photo": null
        }
      ]
    """

  Scenario: Getting all the users filter by email=user3
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/users?email=User3"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "2",
          "username": "user3",
          "email": "user3@kreta.com",
          "enabled": false,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User3",
          "photo": null
        }
      ]
    """

  Scenario: Getting all the users filter by username=user3
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/users?username=user3"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "2",
          "username": "user3",
          "email": "user3@kreta.com",
          "enabled": false,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User3",
          "photo": null
        }
      ]
    """

  Scenario: Getting all the users filter by firstName=Kreta
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/users?firstName=Kreta"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "username": "user",
          "email": "user@kreta.com",
          "enabled": true,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User",
          "photo": {
            "id": "1",
            "created_at": "2014-10-30T00:00:00+0100",
            "name": "http://kreta.test:8000/media/image/user-1.jpg",
            "updated_at": null
          }
        },
        {
          "id": "1",
          "username": "user2",
          "email": "user2@kreta.com",
          "enabled": true,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User2",
          "photo": {
            "id": "2",
            "created_at": "2014-10-30T00:00:00+0100",
            "name": "http://kreta.test:8000/media/image/user-2.jpg",
            "updated_at": null
          }
        },
        {
          "id": "2",
          "username": "user3",
          "email": "user3@kreta.com",
          "enabled": false,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User3",
          "photo": null
        }
      ]
    """

  Scenario: Getting all the users filter by lastName=user3
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/users?lastName=user3"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "2",
          "username": "user3",
          "email": "user3@kreta.com",
          "enabled": false,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User3",
          "photo": null
        }
      ]
    """

  Scenario: Getting all the users filter by enabled=1
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/users?enabled=1"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "username": "user",
          "email": "user@kreta.com",
          "enabled": true,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User",
          "photo": {
            "id": "1",
            "created_at": "2014-10-30T00:00:00+0100",
            "name": "http://kreta.test:8000/media/image/user-1.jpg",
            "updated_at": null
          }
        },
        {
          "id": "1",
          "username": "user2",
          "email": "user2@kreta.com",
          "enabled": true,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User2",
          "photo": {
            "id": "2",
            "created_at": "2014-10-30T00:00:00+0100",
            "name": "http://kreta.test:8000/media/image/user-2.jpg",
            "updated_at": null
          }
        }
      ]
    """

  Scenario: Getting all the issues with limit 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/users?limit=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "username": "user",
          "email": "user@kreta.com",
          "enabled": true,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User",
          "photo": {
            "id": "1",
            "created_at": "2014-10-30T00:00:00+0100",
            "name": "http://kreta.test:8000/media/image/user-1.jpg",
            "updated_at": null
          }
        },
        {
          "id": "1",
          "username": "user2",
          "email": "user2@kreta.com",
          "enabled": true,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User2",
          "photo": {
            "id": "2",
            "created_at": "2014-10-30T00:00:00+0100",
            "name": "http://kreta.test:8000/media/image/user-2.jpg",
            "updated_at": null
          }
        }
      ]
    """

  Scenario: Getting all the issues with offset 1
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/users?offset=1"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "1",
          "username": "user2",
          "email": "user2@kreta.com",
          "enabled": true,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User2",
          "photo": {
            "id": "2",
            "created_at": "2014-10-30T00:00:00+0100",
            "name": "http://kreta.test:8000/media/image/user-2.jpg",
            "updated_at": null
          }
        },
        {
          "id": "2",
          "username": "user3",
          "email": "user3@kreta.com",
          "enabled": false,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User3",
          "photo": null
        }
      ]
    """
