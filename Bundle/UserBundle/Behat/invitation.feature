# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@invitation
Feature: Manage user invitations
  In order to manage user invitations
  As an API invitation
  I want to be able to post users

  Background:
    Given the following users exist:
      | id | firstName | lastName | email           | password | createdAt  | roles                      | enabled |
      | 0  | Kreta     | User     | user@kreta.com  | 123456   | 2014-10-20 | ROLE_ADMIN, ROLE_MARKETING | true    |
      | 1  | Kreta     | User2    | user2@kreta.com | 123456   | 2014-10-20 | ROLE_ADMIN                 | true    |
      | 2  | Kreta     | User3    | user3@kreta.com | 123456   | 2014-10-20 |                            | true    |
      | 3  | Kreta     | User4    | user4@kreta.com | 123456   | 2014-10-20 |                            | false   |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |
      | access-token-3 | null      | user  | user4@kreta.com |

  Scenario: Creating a user invitation
    Given I am authenticating with "access-token-0" token
    And I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/users" with body:
    """
      {
        "email": "newemail@kreta.com"
      }
    """
    Then the response code should be 201

  Scenario: Creating a user invitation of existing email
    Given I am authenticating with "access-token-0" token
    And I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/users" with body:
    """
      {
        "email": "user4@kreta.com"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "email": [
          "This email is already invited"
        ]
      }
    """

  Scenario: Creating a user invitation of enabled user email
    Given I am authenticating with "access-token-0" token
    And I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/users" with body:
    """
      {
        "email": "user2@kreta.com"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      [
        "This user is already an enabled kreta user"
      ]
    """

  Scenario: Creating a user invitation of existing email with force=true
    Given I am authenticating with "access-token-0" token
    And I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/users" with body:
    """
      {
        "email": "user4@kreta.com",
        "force": true
      }
    """
    Then the response code should be 201

  Scenario: Creating a user invitation without ROLE_ADMIN
    Given I am authenticating with "access-token-2" token
    And I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/users"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """
