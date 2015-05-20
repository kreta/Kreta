# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@profile
Feature: Manage user profile
  In order to manage user profile
  As an API profile
  I want to be able to GET and PUT profile

  Background:
    Given the following users exist:
      | id | firstName | lastName | email           | password | createdAt  |
      | 0  | Kreta     | User     | user@kreta.com  | 123456   | 2014-10-20 |
      | 1  | Kreta     | User2    | user2@kreta.com | 123456   | 2014-10-20 |
      | 2  | Kreta     | User3    | user3@kreta.com | 123456   | 2014-10-20 |
      | 3  | Kreta     | User4    | user4@kreta.com | 123456   | 2014-10-20 |
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

  Scenario: Getting the profile of user logged
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/profile"
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "email": "user@kreta.com",
        "enabled": true,
        "created_at": "2014-10-20T00:00:00+0200",
        "first_name": "Kreta",
        "last_name": "User",
        "photo": {
          "id": "1",
          "created_at": "2014-10-30T00:00:00+0100",
          "name": "http://localhost/app_test.php/media/image/user-1.jpg"
        },
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/profile"
          },
          "projects": {
            "href": "http://localhost/app_test.php/api/projects"
          }
        }
      }
    """

  Scenario: Updating the user profile
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/profile" with body:
    """
      {
        "firstName": "Updated name",
        "lastName": "Updated last name"
      }
    """
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "email": "user@kreta.com",
        "enabled": true,
        "created_at": "2014-10-20T00:00:00+0200",
        "first_name": "Updated name",
        "last_name": "Updated last name",
        "photo": {
          "id": "1",
          "created_at": "2014-10-30T00:00:00+0100",
          "name": "http://localhost/app_test.php/media/image/user-1.jpg"
        },
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/profile"
          },
          "projects": {
            "href": "http://localhost/app_test.php/api/projects"
          }
        }
      }
    """

  Scenario: Updating the profile without parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/profile" with body:
    """
      {
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "firstName": [],
        "lastName": [],
        "photo": []
      }
    """

  Scenario: Updating the profile without required last name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/profile" with body:
    """
      {
        "first_name": "Updated name"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "lastName": [
          "This value should not be blank."
        ]
      }
    """

  Scenario: Updating the profile without required first name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/profile" with body:
    """
      {
        "last_name": "Updated last name"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "firstName": [
          "This value should not be blank."
        ]
      }
    """
