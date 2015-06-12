# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@user
Feature: Manage users
  In order to manage users
  As an API user
  I want to be able to GET user

  Background:
    Given the following users exist:
      | id | firstName | lastName | username | email           | password | createdAt  |
      | 0  | Kreta     | User     | user     | user@kreta.com  | 123456   | 2014-10-20 |
      | 1  | Kreta     | User2    | user2    | user2@kreta.com | 123456   | 2014-10-20 |
      | 2  | Kreta     | User3    | user3    | user3@kreta.com | 123456   | 2014-10-20 |
      | 3  | Kreta     | User4    | user4    | user4@kreta.com | 123456   | 2014-10-20 |
    And the following medias exist:
      | id | name       | createdAt  | updatedAt | resource        |
      | 1  | user-1.jpg | 2014-10-30 | null      | user@kreta.com  |
      | 2  | user-2.jpg | 2014-10-30 | null      | user2@kreta.com |
      | 3  | user-3.jpg | 2014-10-30 | null      | user3@kreta.com |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |
      | access-token-3 | null      | user  | user4@kreta.com |

  Scenario: Getting all the users
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/users"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "email": "user@kreta.com",
          "enabled": true,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User",
          "photo": {
          "created_at": "2014-10-30T00:00:00+0100",
            "name": "http://localhost/app_test.php/media/image/user-1.jpg"
          }
        },
        {
          "id": "1",
          "email": "user2@kreta.com",
          "enabled": true,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User2",
          "photo": {
            "created_at": "2014-10-30T00:00:00+0100",
            "name": "http://localhost/app_test.php/media/image/user-2.jpg"
          }
        },
        {
          "id": "2",
          "email": "user3@kreta.com",
          "enabled": true,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User3",
          "photo": {
            "created_at": "2014-10-30T00:00:00+0100",
            "name": "http://localhost/app_test.php/media/image/user-3.jpg"
          }
        },
        {
          "id": "3",
          "email": "user4@kreta.com",
          "enabled": true,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User4"
        }
      ]
    """
