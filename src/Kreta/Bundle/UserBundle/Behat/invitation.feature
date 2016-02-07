# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

@invitation
Feature: Manage user invitations
  In order to manage user invitations
  As an API invitation
  I want to be able to post users

  Background:
    Given the following users exist:
      | id | firstName | lastName | username | email           | password | createdAt  | roles                      | enabled | confirmationToken |
      | 0  | Kreta     | User     | user     | user@kreta.com  | 123456   | 2014-10-20 | ROLE_ADMIN, ROLE_MARKETING | true    |                   |
      | 1  | Kreta     | User2    | user2    | user2@kreta.com | 123456   | 2014-10-20 | ROLE_ADMIN                 | true    |                   |
      | 2  | Kreta     | User3    | user3    | user3@kreta.com | 123456   | 2014-10-20 |                            | true    |                   |
      | 3  | Kreta     | User4    | user4    | user4@kreta.com | 123456   | 2014-10-20 |                            | false   | dummy-token       |
    And the following tokens exist:
      | token          | expiresAt | scope | user            | clientId  |
      | access-token-0 | null      | user  | user@kreta.com  | client-id |
      | access-token-1 | null      | user  | user2@kreta.com | client-id |
      | access-token-2 | null      | user  | user3@kreta.com | client-id |
      | access-token-3 | null      | user  | user4@kreta.com | client-id |

  Scenario: Creating a user invitation
    Given I am authenticating with "access-token-0" token
    And I set header "content-type" with value "application/json"
    When I send a POST request to "/api/users" with body:
    """
      {
        "username": "newuser",
        "email": "newemail@kreta.com",
        "firstName": "Kreta",
        "lastName": "NewUser"
      }
    """
    Then the response code should be 201

  Scenario: Creating a user invitation of existing email
    Given I am authenticating with "access-token-0" token
    And I set header "content-type" with value "application/json"
    When I send a POST request to "/api/users" with body:
    """
      {
        "username": "user4",
        "email": "user4@kreta.com",
        "firstName": "Kreta",
        "lastName": "User4"
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
    When I send a POST request to "/api/users" with body:
    """
      {
        "username": "user2",
        "email": "user2@kreta.com",
        "firstName": "Kreta",
        "lastName": "User2"
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
    When I send a POST request to "/api/users" with body:
    """
      {
        "username": "user4",
        "email": "user4@kreta.com",
        "firstName": "Kreta",
        "lastName": "User4",
        "force": true
      }
    """
    Then the response code should be 201

  Scenario: Visiting the unique url of pending to enabled the invited email
    Given I am on "/register?token=dummy-token"
    When I fill in the following:
      | plainPassword_first  | 123456 |
      | plainPassword_second | 123456 |
    And I press "register"
    Then I should be on the dashboard
    And I should see an access_token inside cookie

  Scenario: Creating a user invitation without ROLE_ADMIN
    Given I am authenticating with "access-token-2" token
    And I set header "content-type" with value "application/json"
    When I send a POST request to "/api/users"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """
