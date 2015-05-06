# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@notification
Feature: Manage notification
  In order to manage notifications
  As an API notification
  I want to be able to GET, and PATCH notifications

  Background:
    Given the following users exist:
      | id | firstName | lastName | email           | password | createdAt  |
      | 0  | Kreta     | User     | user@kreta.com  | 123456   | 2014-10-20 |
      | 1  | Kreta     | User2    | user2@kreta.com | 123456   | 2014-10-20 |
    And the following projects exist:
      | id | name           | shortName | creator        |
      | 0  | Test project 1 | TPR1      | user@kreta.com |
      | 1  | Test project 2 | TPR2      | user@kreta.com |
    And the following notifications exist:
      | id | description                    | date       | read  | resourceUrl            | title          | project        | type           | user            | webUrl                 |
      | 0  | The notification-0 description | 2015-04-20 | true  | /api/issues/id-issue   | Notification 1 | Test project 1 | issue_new      | user@kreta.com  | /api/issues/id-issue   |
      | 1  | The notification-1 description | 2015-04-20 | false | /api/issues/id-issue-2 | Notification 2 | Test project 2 | issue_new      | user@kreta.com  | /api/issues/id-issue-2 |
      | 2  | The notification-2 description | 2015-04-20 | false | /api/issues/is-issue-3 | Notification 3 | Test project 2 | issue_new      | user@kreta.com  | /api/issues/id-issue-3 |
      | 3  | The notification-3 description | 2015-04-24 | false | /api/issues/is-issue-4 | Notification 4 | Test project 2 | issue_new      | user@kreta.com  | /api/issues/id-issue-4 |
      | 4  | The notification-4 description | 2015-04-20 | false | /api/issues/is-issue-5 | Notification 5 | Test project 1 | issue_new      | user2@kreta.com | /api/issues/id-issue-5 |
      | 5  | The notification-5 description | 2015-04-20 | false | /api/issues/is-issue-6 | Notification 6 | Test project 1 | project_update | user2@kreta.com | /api/issues/id-issue-6 |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |

  Scenario: Getting all the notifications of user@kreta.com
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/notifications"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-0 description",
          "read": true,
          "resource_url": "/api/issues/id-issue",
          "title": "Notification 1",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "1",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-1 description",
          "read": false,
          "resource_url": "/api/issues/id-issue-2",
          "title": "Notification 2",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-2",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "2",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-2 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-3",
          "title": "Notification 3",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-3",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "3",
          "date": "2015-04-24T00:00:00+0200",
          "description": "The notification-3 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-4",
          "title": "Notification 4",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-4",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the notifications with filter read to false of user@kreta.com
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/notifications?read=false"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-0 description",
          "read": true,
          "resource_url": "/api/issues/id-issue",
          "title": "Notification 1",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the read notifications of user@kreta.com
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/notifications?read=true"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-0 description",
          "read": true,
          "resource_url": "/api/issues/id-issue",
          "title": "Notification 1",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the notifications of user@kreta.com filter by title
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/notifications?q=Notification 1"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-0 description",
          "read": true,
          "resource_url": "/api/issues/id-issue",
          "title": "Notification 1",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the notifications of user@kreta.com filter by project
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/notifications?project=0"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-0 description",
          "read": true,
          "resource_url": "/api/issues/id-issue",
          "title": "Notification 1",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the notifications of user@kreta.com filter by type
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/notifications?type=issue_new"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-0 description",
          "read": true,
          "resource_url": "/api/issues/id-issue",
          "title": "Notification 1",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "1",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-1 description",
          "read": false,
          "resource_url": "/api/issues/id-issue-2",
          "title": "Notification 2",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-2",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "2",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-2 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-3",
          "title": "Notification 3",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-3",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "3",
          "date": "2015-04-24T00:00:00+0200",
          "description": "The notification-3 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-4",
          "title": "Notification 4",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-4",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the notifications of user@kreta.com filter by date
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/notifications?date=2015-04-23"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "3",
          "date": "2015-04-24T00:00:00+0200",
          "description": "The notification-3 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-4",
          "title": "Notification 4",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-4",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the notifications of user@kreta.com order by title
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/notifications?sort=title"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-0 description",
          "read": true,
          "resource_url": "/api/issues/id-issue",
          "title": "Notification 1",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "1",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-1 description",
          "read": false,
          "resource_url": "/api/issues/id-issue-2",
          "title": "Notification 2",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-2",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "2",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-2 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-3",
          "title": "Notification 3",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-3",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "3",
          "date": "2015-04-24T00:00:00+0200",
          "description": "The notification-3 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-4",
          "title": "Notification 4",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-4",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the notifications of user@kreta.com order by date
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/notifications?sort=date"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-0 description",
          "read": true,
          "resource_url": "/api/issues/id-issue",
          "title": "Notification 1",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "1",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-1 description",
          "read": false,
          "resource_url": "/api/issues/id-issue-2",
          "title": "Notification 2",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-2",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "2",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-2 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-3",
          "title": "Notification 3",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-3",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "3",
          "date": "2015-04-24T00:00:00+0200",
          "description": "The notification-3 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-4",
          "title": "Notification 4",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-4",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the notifications of user2@kreta.com order by type
    Given I am authenticating with "access-token-1" token
    When I send a GET request to "/app_test.php/api/notifications?sort=type"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "4",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-4 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-5",
          "title": "Notification 5",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-5",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "5",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-5 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-6",
          "title": "Notification 6",
          "type": "project_update",
          "web_url": "/api/issues/id-issue-6",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the notifications of user@kreta.com order by read
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/notifications?sort=read"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "1",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-1 description",
          "read": false,
          "resource_url": "/api/issues/id-issue-2",
          "title": "Notification 2",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-2",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "2",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-2 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-3",
          "title": "Notification 3",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-3",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "3",
          "date": "2015-04-24T00:00:00+0200",
          "description": "The notification-3 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-4",
          "title": "Notification 4",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-4",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "0",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-0 description",
          "read": true,
          "resource_url": "/api/issues/id-issue",
          "title": "Notification 1",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the notifications of user@kreta.com limit by 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/notifications?limit=2"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "0",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-0 description",
          "read": true,
          "resource_url": "/api/issues/id-issue",
          "title": "Notification 1",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        },
        {
          "id": "1",
          "date": "2015-04-20T00:00:00+0200",
          "description": "The notification-1 description",
          "read": false,
          "resource_url": "/api/issues/id-issue-2",
          "title": "Notification 2",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-2",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Getting all the notifications of user@kreta.com offset by 3
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/notifications?offset=3"
    Then the response code should be 200
    And the response should contain json:
    """
      [
        {
          "id": "3",
          "date": "2015-04-24T00:00:00+0200",
          "description": "The notification-3 description",
          "read": false,
          "resource_url": "/api/issues/is-issue-4",
          "title": "Notification 4",
          "type": "issue_new",
          "web_url": "/api/issues/id-issue-4",
          "_links": {
            "notifications": {
              "href": "http://localhost/app_test.php/api/notifications"
            },
            "projects": {
              "href": "http://localhost/app_test.php/api/projects"
            }
          }
        }
      ]
    """

  Scenario: Marking as read the 3 notification with user which is not participant
    Given I am authenticating with "access-token-1" token
    Given I set header "content-type" with value "application/json"
    When I send a PATCH request to "/app_test.php/api/notifications/3" with body:
    """
      {
        "read": true
      }
    """
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Marking as read the unknown notification
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PATCH request to "/app_test.php/api/notifications/unknown-notification" with body:
    """
      {
        "read": true
      }
    """
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Marking as read the 3 notification without passing the read body parameter
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PATCH request to "/app_test.php/api/notifications/3" with body:
    """
      {}
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "read": []
      }
    """

  Scenario: Marking as read the 3 notification without read equals to true or false in the body
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PATCH request to "/app_test.php/api/notifications/3" with body:
    """
      {
        "read": "other value"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "read": ["This value is not valid."]
      }
    """

  Scenario: Marking as read the 3 notification
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PATCH request to "/app_test.php/api/notifications/3" with body:
    """
      {
        "read": true
      }
    """
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "3",
        "date": "2015-04-24T00:00:00+0200",
        "description": "The notification-3 description",
        "read": true,
        "resource_url": "/api/issues/is-issue-4",
        "title": "Notification 4",
        "type": "issue_new",
        "web_url": "/api/issues/id-issue-4",
        "_links": {
          "notifications": {
            "href": "http://localhost/app_test.php/api/notifications"
          },
          "projects": {
            "href": "http://localhost/app_test.php/api/projects"
          }
        }
      }
    """

  Scenario: Marking as unread the 3 notification
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PATCH request to "/app_test.php/api/notifications/3" with body:
    """
      {
        "read": false
      }
    """
    And print response
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "3",
        "date": "2015-04-24T00:00:00+0200",
        "description": "The notification-3 description",
        "resource_url": "/api/issues/is-issue-4",
        "title": "Notification 4",
        "type": "issue_new",
        "web_url": "/api/issues/id-issue-4",
        "_links": {
          "notifications": {
            "href": "http://localhost/app_test.php/api/notifications"
          },
          "projects": {
            "href": "http://localhost/app_test.php/api/projects"
          }
        }
      }
    """

  Scenario: Marking as unread the 3 notification with user which is not participant
    Given I am authenticating with "access-token-1" token
    Given I set header "content-type" with value "application/json"
    When I send a PATCH request to "/app_test.php/api/notifications/3" with body:
    """
      {
        "read": false
      }
    """
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Marking as unread the unknown notification
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PATCH request to "/app_test.php/api/notifications/unknown-notification" with body:
    """
      {
        "read": false
      }
    """
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """
