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
      | id | firstName | lastName | email           | password | createdAt  | roles                      | enabled | confirmationToken |
      | 0  | Kreta     | User     | user@kreta.com  | 123456   | 2014-10-20 | ROLE_ADMIN, ROLE_MARKETING | true    |                   |
      | 1  | Kreta     | User2    | user2@kreta.com | 123456   | 2014-10-20 | ROLE_ADMIN                 | true    |                   |
      | 2  | Kreta     | User3    | user3@kreta.com | 123456   | 2014-10-20 |                            | true    |                   |
      | 3  | Kreta     | User4    | user4@kreta.com | 123456   | 2014-10-20 |                            | false   | dummy-token       |
    And the following tokens exist:
      | token          | expiresAt | scope | user            | clientId  |
      | access-token-0 | null      | user  | user@kreta.com  | client-id |
      | access-token-1 | null      | user  | user2@kreta.com | client-id |
      | access-token-2 | null      | user  | user3@kreta.com | client-id |
      | access-token-3 | null      | user  | user4@kreta.com | client-id |

  Scenario: Creating a user invitation
    Given I am authenticating with "access-token-0" token
    And I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/users" with body:
    """
      {
        "email": "newemail@kreta.com"
      }
    """
    And print response
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

  Scenario: Visiting the unique url of pending to enabled the invited email
    Given I am on "/register?token=dummy-token"
    When I fill in the following:
      | plainPassword_first  | 123456 |
      | plainPassword_second | 123456 |
    And I press "register"
    Then I should be on the dashboard
    And I should see refresh_token and access_token cookies

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
