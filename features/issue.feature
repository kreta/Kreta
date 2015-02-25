# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@issue
Feature: Manage issue
  In order to manage issues
  As an API issue
  I want to be able to GET, POST and PUT issues

  Background:
    Given the following users exist:
      | id | firstName | lastName | email           | password | createdAt  |
      | 0  | Kreta     | User     | user@kreta.com  | 123456   | 2014-10-20 |
      | 1  | Kreta     | User2    | user2@kreta.com | 123456   | 2014-10-20 |
      | 2  | Kreta     | User3    | user3@kreta.com | 123456   | 2014-10-20 |
      | 3  | Kreta     | User4    | user4@kreta.com | 123456   | 2014-10-20 |
    And the following workflows exist:
      | id | name       | creator        |
      | 0  | Workflow 1 | user@kreta.com |
      | 1  | Workflow 2 | user@kreta.com |
    And the following projects exist:
      | id | name           | shortName | creator        | workflow   |
      | 0  | Test project 1 | TPR1      | user@kreta.com | Workflow 1 |
      | 1  | Test project 2 | TPR2      | user@kreta.com | Workflow 2 |
    And the following labels exist:
      | id | name        | project        |
      | 0  | backbone.js | Test project 1 |
      | 1  | php         | Test project 2 |
      | 2  | javascript  | Test project 1 |
      | 3  | bdd         | Test project 1 |
      | 4  | behat       | Test project 2 |
      | 5  | phpspec     | Test project 2 |
      | 6  | symfony     | Test project 1 |
      | 7  | html5       | Test project 2 |
      | 8  | css3        | Test project 1 |
      | 9  | sass        | Test project 1 |
      | 10 | compass     | Test project 2 |
      | 11 | mysql       | Test project 1 |
      | 12 | mongodb     | Test project 1 |
    And the following statuses exist:
      | id | color   | name        | workflow   |
      | 0  | #27ae60 | Open        | Workflow 1 |
      | 1  | #2c3e50 | In progress | Workflow 1 |
      | 2  | #f1c40f | Resolved    | Workflow 1 |
      | 3  | #c0392b | Closed      | Workflow 1 |
      | 4  | #27ae60 | Reopened    | Workflow 1 |
    And the following participants exist:
      | project        | user            | role             |
      | Test project 1 | user3@kreta.com | ROLE_PARTICIPANT |
      | Test project 1 | user2@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user2@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user4@kreta.com | ROLE_PARTICIPANT |
    And the following issues exist:
      | id | numericId | project        | title        | description | reporter        | assignee        | type | status   | priority | createdAt  | labels                                   |
      | 0  | 1         | Test project 1 | Test issue 1 | Description | user@kreta.com  | user@kreta.com  | 4    | Open     | 1        | 2014-12-15 | backbone.js,javascript,bdd,symfony,css3  |
      | 1  | 2         | Test project 1 | Test issue 2 | Description | user@kreta.com  | user@kreta.com  | 2    | Resolved | 1        | 2014-11-07 | backbone.js,javascript,bdd,symfony,css3  |
      | 2  | 3         | Test project 1 | Test issue 3 | Description | user@kreta.com  | user@kreta.com  | 1    | Resolved | 1        | 2014-10-21 | backbone.js,javascript,bdd,mysql,mongodb |
      | 3  | 1         | Test project 2 | Test issue 1 | Description | user@kreta.com  | user4@kreta.com | 3    | Resolved | 1        | 2014-10-21 | php,behat,phpspec,html5,compass          |
      | 4  | 2         | Test project 2 | Test issue 1 | Description | user4@kreta.com | user@kreta.com  | 1    | Resolved | 1        | 2014-10-21 | php,behat,phpspec,html5,compass          |
      | 5  | 4         | Test project 1 | Test issue 4 | Description | user2@kreta.com | user@kreta.com  | 0    | Closed   | 0        | 2014-10-21 | backbone.js,javascript,bdd,mysql,mongodb |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |
      | access-token-3 | null      | user  | user4@kreta.com |

  Scenario: Getting all the issues of project 0
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "0",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "created_at": "2014-12-15T00:00:00+0100",
        "description": "Description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }, {
          "id": "6",
          "name": "symfony"
        }, {
          "id": "8",
          "name": "css3"
        }],
        "numeric_id": 1,
        "priority": 1,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "type": "normal",
          "name": "Open",
          "id": "0",
          "color": "#27ae60"
        },
        "title": "Test issue 1",
        "type": 4,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }, {
        "id": "1",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "created_at": "2014-11-07T00:00:00+0100",
        "description": "Description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }, {
          "id": "6",
          "name": "symfony"
        }, {
          "id": "8",
          "name": "css3"
        }],
        "numeric_id": 2,
        "priority": 1,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "type": "normal",
          "name": "Resolved",
          "id": "2",
          "color": "#f1c40f"
        },
        "title": "Test issue 2",
        "type": 2,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/1"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }, {
        "id": "2",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "Description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "11",
          "name": "mysql"
        }, {
          "id": "12",
          "name": "mongodb"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }],
        "numeric_id": 3,
        "priority": 1,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "type": "normal",
          "name": "Resolved",
          "id": "2",
          "color": "#f1c40f"
        },
        "title": "Test issue 3",
        "type": 1,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/2"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }, {
        "id": "5",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "Description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "11",
          "name": "mysql"
        }, {
          "id": "12",
          "name": "mongodb"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }],
        "numeric_id": 4,
        "priority": 0,
        "reporter": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "status": {
          "type": "normal",
          "name": "Closed",
          "id": "3",
          "color": "#c0392b"
        },
        "title": "Test issue 4",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/5"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }]
    """

  Scenario: Getting all the issues of project 0 with user which is not a project participant
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/app_test.php/api/projects/0/issues"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting all the issues of project unknown project
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/app_test.php/api/projects/unknown-project/issues"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting all the issues of project 0 sorted by createdAt
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues?sort=createdAt"
    Then the response code should be 200
    And the response should contain json:
    """
    [{
      "id": "2",
      "assignee": {
        "id": "0",
        "email": "user@kreta.com",
        "first_name": "Kreta",
        "last_name": "User"
      },
      "created_at": "2014-10-21T00:00:00+0200",
      "description": "Description",
      "labels": [{
        "id": "0",
        "name": "backbone.js"
      }, {
        "id": "11",
        "name": "mysql"
      }, {
        "id": "12",
        "name": "mongodb"
      }, {
        "id": "2",
        "name": "javascript"
      }, {
        "id": "3",
        "name": "bdd"
      }],
      "numeric_id": 3,
      "numeric_id": 3,
      "priority": 1,
      "reporter": {
        "id": "0",
        "email": "user@kreta.com",
        "first_name": "Kreta",
        "last_name": "User"
      },
      "status": {
        "type": "normal",
        "name": "Resolved",
        "id": "2",
        "color": "#f1c40f"
      },
      "title": "Test issue 3",
      "type": 1,
      "_links": {
        "self": {
          "href": "http://localhost/app_test.php/api/projects/0/issues/2"
        },
        "project": {
          "href": "http://localhost/app_test.php/api/projects/0"
        },
        "issues": {
          "href": "http://localhost/app_test.php/api/projects/0/issues"
        }
      }
    }, {
      "id": "5",
      "assignee": {
        "id": "0",
        "email": "user@kreta.com",
        "first_name": "Kreta",
        "last_name": "User"
      },
      "created_at": "2014-10-21T00:00:00+0200",
      "description": "Description",
      "labels": [{
        "id": "0",
        "name": "backbone.js"
      }, {
        "id": "11",
        "name": "mysql"
      }, {
        "id": "12",
        "name": "mongodb"
      }, {
        "id": "2",
        "name": "javascript"
      }, {
        "id": "3",
        "name": "bdd"
      }],
      "numeric_id": 4,
      "priority": 0,
      "reporter": {
        "id": "1",
        "email": "user2@kreta.com",
        "first_name": "Kreta",
        "last_name": "User2"
      },
      "status": {
        "type": "normal",
        "name": "Closed",
        "id": "3",
        "color": "#c0392b"
      },
      "title": "Test issue 4",
      "type": 0,
      "_links": {
        "self": {
          "href": "http://localhost/app_test.php/api/projects/0/issues/5"
        },
        "project": {
          "href": "http://localhost/app_test.php/api/projects/0"
        },
        "issues": {
          "href": "http://localhost/app_test.php/api/projects/0/issues"
        }
      }
    }, {
      "id": "1",
      "assignee": {
        "id": "0",
        "email": "user@kreta.com",
        "first_name": "Kreta",
        "last_name": "User"
      },
      "created_at": "2014-11-07T00:00:00+0100",
      "description": "Description",
      "labels": [{
          "id": "0",
          "name": "backbone.js"
      }, {
        "id": "2",
        "name": "javascript"
      }, {
        "id": "3",
        "name": "bdd"
      }, {
        "id": "6",
        "name": "symfony"
      }, {
        "id": "8",
        "name": "css3"
      }],
      "numeric_id": 2,
      "priority": 1,
      "reporter": {
        "id": "0",
        "email": "user@kreta.com",
        "first_name": "Kreta",
        "last_name": "User"
      },
      "status": {
        "type": "normal",
        "name": "Resolved",
        "id": "2",
        "color": "#f1c40f"
      },
      "title": "Test issue 2",
      "type": 2,
      "_links": {
        "self": {
          "href": "http://localhost/app_test.php/api/projects/0/issues/1"
        },
        "project": {
          "href": "http://localhost/app_test.php/api/projects/0"
        },
        "issues": {
          "href": "http://localhost/app_test.php/api/projects/0/issues"
        }
      }
    }, {
      "id": "0",
      "assignee": {
        "id": "0",
        "email": "user@kreta.com",
        "first_name": "Kreta",
        "last_name": "User"
      },
      "created_at": "2014-12-15T00:00:00+0100",
      "description": "Description",
      "labels": [{
        "id": "0",
        "name": "backbone.js"
      }, {
        "id": "2",
        "name": "javascript"
      }, {
        "id": "3",
        "name": "bdd"
      }, {
        "id": "6",
        "name": "symfony"
      }, {
        "id": "8",
        "name": "css3"
      }],
      "numeric_id": 1,
      "priority": 1,
      "reporter": {
        "id": "0",
        "email": "user@kreta.com",
        "first_name": "Kreta",
        "last_name": "User"
      },
      "status": {
        "type": "normal",
        "name": "Open",
        "id": "0",
        "color": "#27ae60"
      },
      "title": "Test issue 1",
      "type": 4,
      "_links": {
        "self": {
          "href": "http://localhost/app_test.php/api/projects/0/issues/0"
        },
        "project": {
          "href": "http://localhost/app_test.php/api/projects/0"
        },
        "issues": {
          "href": "http://localhost/app_test.php/api/projects/0/issues"
        }
      }
    }]
    """

  Scenario: Getting all the issues of project 1 filter by assignee=user4@kreta.com
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/1/issues?assignee=user4@kreta.com"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "3",
        "assignee": {
          "id": "3",
          "email": "user4@kreta.com",
          "first_name": "Kreta",
          "last_name": "User4"
        },
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "Description",
        "labels": [{
          "id": "1",
          "name": "php"
        }, {
          "id": "10",
          "name": "compass"
        }, {
          "id": "4",
          "name": "behat"
        }, {
          "id": "5",
          "name": "phpspec"
        }, {
          "id": "7",
          "name": "html5"
        }],
        "numeric_id": 1,
        "priority": 1,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "type": "normal",
          "name": "Resolved",
          "id": "2",
          "color": "#f1c40f"
        },
        "title": "Test issue 1",
        "type": 3,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/1/issues/3"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/1"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/1/issues"
          }
        }
      }]
    """

  Scenario: Getting all the issues of project 1 filter by reporter=user4@kreta.com
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/1/issues?reporter=user4@kreta.com"
    Then the response code should be 200
    And the response should contain json:
    """
    [{
      "id": "4",
      "assignee": {
        "id": "0",
        "email": "user@kreta.com",
        "first_name": "Kreta",
        "last_name": "User"
      },
      "created_at": "2014-10-21T00:00:00+0200",
      "description": "Description",
      "labels": [{
        "id": "1",
        "name": "php"
      }, {
        "id": "10",
        "name": "compass"
      }, {
        "id": "4",
        "name": "behat"
      }, {
        "id": "5",
        "name": "phpspec"
      }, {
        "id": "7",
        "name": "html5"
      }],
      "numeric_id": 2,
      "priority": 1,
      "reporter": {
        "id": "3",
        "email": "user4@kreta.com",
        "first_name": "Kreta",
        "last_name": "User4"
      },
      "status": {
        "type": "normal",
        "name": "Resolved",
        "id": "2",
        "color": "#f1c40f"
      },
      "title": "Test issue 1",
      "type": 1,
      "_links": {
        "self": {
          "href": "http://localhost/app_test.php/api/projects/1/issues/4"
        },
        "project": {
          "href": "http://localhost/app_test.php/api/projects/1"
        },
        "issues": {
          "href": "http://localhost/app_test.php/api/projects/1/issues"
        }
      }
    }]
    """

  Scenario: Getting all the issues of project 0 filter by priority=0
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues?priority=0"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "5",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "Description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "11",
          "name": "mysql"
        }, {
          "id": "12",
          "name": "mongodb"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }],
        "numeric_id": 4,
        "priority": 0,
        "reporter": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "status": {
          "type": "normal",
          "name": "Closed",
          "id": "3",
          "color": "#c0392b"
        },
        "title": "Test issue 4",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/5"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }]
    """

  Scenario: Getting all the issues of project 0 filter by status=closed
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues?status=closed"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "5",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "Description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "11",
          "name": "mysql"
        }, {
          "id": "12",
          "name": "mongodb"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }],
        "numeric_id": 4,
        "priority": 0,
        "reporter": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "status": {
          "type": "normal",
          "name": "Closed",
          "id": "3",
          "color": "#c0392b"
        },
        "title": "Test issue 4",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/5"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }]
    """

  Scenario: Getting all the issues of project 0 filter by type=0
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues?type=0"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "5",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "Description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "11",
          "name": "mysql"
        }, {
          "id": "12",
          "name": "mongodb"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }],
        "numeric_id": 4,
        "priority": 0,
        "reporter": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "status": {
          "type": "normal",
          "name": "Closed",
          "id": "3",
          "color": "#c0392b"
        },
        "title": "Test issue 4",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/5"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }]
    """

  Scenario: Getting all the issues of project 0 filter by title=issue 4
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues?q=issue 4"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "5",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "Description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "11",
          "name": "mysql"
        }, {
          "id": "12",
          "name": "mongodb"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }],
        "numeric_id": 4,
        "priority": 0,
        "reporter": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "status": {
          "type": "normal",
          "name": "Closed",
          "id": "3",
          "color": "#c0392b"
        },
        "title": "Test issue 4",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/5"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }]
    """

  Scenario: Getting all the issues of project 0 with limit 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues?limit=2"
    Then the response code should be 200
    And print response
    And the response should contain json:
    """
      [{
        "id": "0",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "created_at": "2014-12-15T00:00:00+0100",
        "description": "Description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }, {
          "id": "6",
          "name": "symfony"
        }, {
          "id": "8",
          "name": "css3"
        }],
        "numeric_id": 1,
        "priority": 1,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "type": "normal",
          "name": "Open",
          "id": "0",
          "color": "#27ae60"
        },
        "title": "Test issue 1",
        "type": 4,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }, {
        "id": "1",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "created_at": "2014-11-07T00:00:00+0100",
        "description": "Description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }, {
          "id": "6",
          "name": "symfony"
        }, {
          "id": "8",
          "name": "css3"
        }],
        "numeric_id": 2,
        "priority": 1,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "type": "normal",
          "name": "Resolved",
          "id": "2",
          "color": "#f1c40f"
        },
        "title": "Test issue 2",
        "type": 2,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/1"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }]
    """

  Scenario: Getting all the issues of project 0 with offset 2
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues?offset=2"
    Then the response code should be 200
    And print response
    And the response should contain json:
    """
      [{
        "id": "2",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "Description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "11",
          "name": "mysql"
        }, {
          "id": "12",
          "name": "mongodb"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }],
        "numeric_id": 3,
        "priority": 1,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "type": "normal",
          "name": "Resolved",
          "id": "2",
          "color": "#f1c40f"
        },
        "title": "Test issue 3",
        "type": 1,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/2"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }, {
        "id": "5",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "Description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "11",
          "name": "mysql"
        }, {
          "id": "12",
          "name": "mongodb"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }],
        "numeric_id": 4,
        "priority": 0,
        "reporter": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "status": {
          "type": "normal",
          "name": "Closed",
          "id": "3",
          "color": "#c0392b"
        },
        "title": "Test issue 4",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/5"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }]
    """

  Scenario: Getting the 0 issue
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/0"
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "assignee": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "created_at": "2014-12-15T00:00:00+0100",
        "description": "Description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }, {
          "id": "6",
          "name": "symfony"
        }, {
          "id": "8",
          "name": "css3"
        }],
        "numeric_id": 1,
        "priority": 1,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "id": "0",
          "color": "#27ae60",
          "type": "normal",
          "name": "Open"
        },
        "title": "Test issue 1",
        "type": 4,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }
    """

  Scenario: Getting the 1 issue with user which is not a participant
    Given I am authenticating with "access-token-3" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/1"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Getting the unknown issue
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/app_test.php/api/projects/0/issues/unknown-issue"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Creating a issue
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/issues" with body:
    """
      {
        "title": "New issue",
        "description": "The description",
        "type": "0",
        "priority": "0",
        "assignee": "1"
      }
    """
    Then the response code should be 201

  Scenario: Creating a issue assigning to user which is not a project participant
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/1/issues" with body:
    """
      {
        "title": "New issue",
        "description": "The description",
        "type": "0",
        "priority": "0",
        "assignee": "2"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "assignee": [
          "This value is not valid."
        ]
      }
    """

  Scenario: Creating a issue without parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/1/issues" with body:
    """
      {
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "title": [],
        "description": [],
        "type": [],
        "priority": [],
        "assignee": []
      }
    """

  Scenario: Creating a issue without required parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/1/issues" with body:
    """
      {
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "title": [
          "This value should not be blank."
        ],
        "type": [
          "This value should not be blank."
        ],
        "priority": [
          "This value should not be blank."
        ]
      }
    """

  Scenario: Creating a issue with already exists title
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/app_test.php/api/projects/0/issues" with body:
    """
      {
        "title": "Test issue 1",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "title": [
          "An issue with identical title is already exists in this project"
        ]
      } 
    """

  Scenario: Creating an issue with user which is not a participant
    Given I am authenticating with "access-token-2" token
    When I send a POST request to "/app_test.php/api/projects/1/issues" with body:
    """
      {
        "title": "New issue",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Updating the 0 issue
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/0/issues/0" with body:
    """
      {
        "title": "Test issue 1",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "assignee": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "created_at": "2014-12-15T00:00:00+0100",
        "description": "The description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }, {
          "id": "6",
          "name": "symfony"
        }, {
          "id": "8",
          "name": "css3"
        }],
        "numeric_id": 1,
        "priority": 0,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "id": "0",
          "color": "#27ae60",
          "type": "normal",
          "name": "Open"
        },
        "title": "Test issue 1",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      } 
    """

  Scenario: Updating the 0 issue without parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/0/issues/0" with body:
    """
      {
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "title": [],
        "description": [],
        "type": [],
        "priority": [],
        "assignee": []
      }
    """

  Scenario: Updating the 0 issue without required parameters
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/0/issues/0" with body:
    """
      {
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "title": [
          "This value should not be blank."
        ],
        "type": [
          "This value should not be blank."
        ],
        "priority": [
          "This value should not be blank."
        ]
      }
    """

  Scenario: Updating the 1 issue with user which is participant
    Given I am authenticating with "access-token-2" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/1/issues/0" with body:
    """
      {
        "title": "Updated issue",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Updating the 1 issue with user which is assignee
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/0/issues/2" with body:
    """
      {
        "title": "Updated issue 0",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "2",
        "assignee": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "The description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "11",
          "name": "mysql"
        }, {
          "id": "12",
          "name": "mongodb"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }],
        "numeric_id": 3,
        "priority": 0,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "id": "2",
          "color": "#f1c40f",
          "type": "normal",
          "name": "Resolved"
        },
        "title": "Updated issue 0",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/2"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      }
    """

  Scenario: Updating the 1 issue with user which is reporter
    Given I am authenticating with "access-token-3" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/1/issues/3" with body:
    """
      {
        "title": "Updated issue 1",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "3",
        "assignee": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "created_at": "2014-10-21T00:00:00+0200",
        "description": "The description",
        "labels": [{
          "id": "1",
          "name": "php"
        }, {
          "id": "10",
          "name": "compass"
        }, {
          "id": "4",
          "name": "behat"
        }, {
          "id": "5",
          "name": "phpspec"
        }, {
          "id": "7",
          "name": "html5"
        }],
        "numeric_id": 1,
        "priority": 0,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "id": "2",
          "color": "#f1c40f",
          "type": "normal",
          "name": "Resolved"
        },
        "title": "Updated issue 1",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/1/issues/3"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/1"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/1/issues"
          }
        }
      }
    """

  Scenario: Updating the 1 issue with user which is admin
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/app_test.php/api/projects/0/issues/0" with body:
    """
      {
        "title": "Updated issue 2",
        "type": "0",
        "priority": "0",
        "description": "The description",
        "assignee": "1"
      }
    """
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "assignee": {
          "id": "1",
          "email": "user2@kreta.com",
          "first_name": "Kreta",
          "last_name": "User2"
        },
        "created_at": "2014-12-15T00:00:00+0100",
        "description": "The description",
        "labels": [{
          "id": "0",
          "name": "backbone.js"
        }, {
          "id": "2",
          "name": "javascript"
        }, {
          "id": "3",
          "name": "bdd"
        }, {
          "id": "6",
          "name": "symfony"
        }, {
          "id": "8",
          "name": "css3"
        }],
        "numeric_id": 1,
        "priority": 0,
        "reporter": {
          "id": "0",
          "email": "user@kreta.com",
          "first_name": "Kreta",
          "last_name": "User"
        },
        "status": {
          "id": "0",
          "color": "#27ae60",
          "type": "normal",
          "name": "Open"
        },
        "title": "Updated issue 2",
        "type": 0,
        "_links": {
          "self": {
            "href": "http://localhost/app_test.php/api/projects/0/issues/0"
          },
          "project": {
            "href": "http://localhost/app_test.php/api/projects/0"
          },
          "issues": {
            "href": "http://localhost/app_test.php/api/projects/0/issues"
          }
        }
      } 
    """
