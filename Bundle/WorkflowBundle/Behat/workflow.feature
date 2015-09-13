# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

@workflow
Feature: Manage workflow
  In order to manage workflows
  As an API workflow
  I want to be able to GET, POST, PUT workflows

  Background:
    Given the following users exist:
      | id | firstName | lastName | username | email           | password | createdAt  |
      | 0  | Kreta     | User     | user     | user@kreta.com  | 123456   | 2014-10-20 |
      | 1  | Kreta     | User2    | user2    | user2@kreta.com | 123456   | 2014-10-20 |
      | 2  | Kreta     | User3    | user3    | user3@kreta.com | 123456   | 2014-10-20 |
    And the following workflows exist:
      | id | name       | creator         | createdAt  |
      | 0  | Workflow 1 | user@kreta.com  | 2014-11-29 |
      | 1  | Workflow 2 | user@kreta.com  | 2014-11-30 |
      | 2  | Workflow 3 | user2@kreta.com | 2014-11-20 |
      | 3  | Workflow 4 | user@kreta.com  | 2014-12-30 |
      | 4  | Workflow 5 | user@kreta.com  | 2014-09-17 |
      | 5  | Workflow 6 | user@kreta.com  | 2014-10-20 |
    And the following projects exist:
      | id | name           | shortName | creator        | workflow   |
      | 0  | Test project 1 | TPR1      | user@kreta.com | Workflow 1 |
      | 1  | Test project 2 | TPR2      | user@kreta.com | Workflow 2 |
    And the following statuses exist:
      | id | color   | name        | workflow   |
      | 0  | #27ae60 | Open        | Workflow 1 |
      | 1  | #2c3e50 | In progress | Workflow 1 |
      | 2  | #f1c40f | Resolved    | Workflow 1 |
    And the following status transitions exist:
      | id | name            | status      | initialStates    |
      | 0  | Start progress  | Open        | In progress      |
      | 1  | Reopen progress | In progress | Open,Resolved    |
      | 2  | Finish progress | Resolved    | Open,In progress |
    And the following participants exist:
      | project        | user            | role             |
      | Test project 1 | user3@kreta.com | ROLE_PARTICIPANT |
      | Test project 1 | user2@kreta.com | ROLE_PARTICIPANT |
      | Test project 2 | user2@kreta.com | ROLE_PARTICIPANT |
    And the following tokens exist:
      | token          | expiresAt | scope | user            |
      | access-token-0 | null      | user  | user@kreta.com  |
      | access-token-1 | null      | user  | user2@kreta.com |
      | access-token-2 | null      | user  | user3@kreta.com |

  Scenario: Getting all the workflows
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/workflows"
    Then the response code should be 200
    And the response should contain json:
    """
      [{
        "id": "0",
        "created_at": "2014-11-29T00:00:00+0100",
        "name": "Workflow 1",
        "statuses": [
          {
            "type": "normal",
            "name": "Open",
            "id": "0",
            "color": "#27ae60",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/0"
              },
              "statuses": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
              }
            }
          },
          {
            "type": "normal",
            "name": "In progress",
            "id": "1",
            "color": "#2c3e50",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/1"
              },
              "statuses": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
              }
            }
          },
          {
            "type": "normal",
            "name": "Resolved",
            "id": "2",
            "color": "#f1c40f",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/2"
              },
              "statuses": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
              }
            }
          }
        ],
        "status_transitions": [
          {
            "initial_states": [
              {
                "type": "normal",
                "name": "In progress",
                "id": "1",
                "color": "#2c3e50",
                "_links": {
                  "self": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/1"
                  },
                  "statuses": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
                  }
                }
              }
            ],
            "name": "Start progress",
            "id": "0",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/transitions/0"
              },
              "transitions": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/transitions"
              }
            }
          },
          {
            "initial_states": [
              {
                "type": "normal",
                "name": "Open",
                "id": "0",
                "color": "#27ae60",
                "_links": {
                  "self": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/0"
                  },
                  "statuses": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
                  }
                }
              },
              {
                "type": "normal",
                "name": "Resolved",
                "id": "2",
                "color": "#f1c40f",
                "_links": {
                  "self": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/2"
                  },
                  "statuses": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
                  }
                }
              }
            ],
            "name": "Reopen progress",
            "id": "1",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/transitions/1"
              },
              "transitions": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/transitions"
              }
            }
          },
          {
            "initial_states": [
              {
                "type": "normal",
                "name": "Open",
                "id": "0",
                "color": "#27ae60",
                "_links": {
                  "self": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/0"
                  },
                  "statuses": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
                  }
                }
              },
              {
                "type": "normal",
                "name": "In progress",
                "id": "1",
                "color": "#2c3e50",
                "_links": {
                  "self": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/1"
                  },
                  "statuses": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
                  }
                }
              }
            ],
            "name": "Finish progress",
            "id": "2",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/transitions/2"
              },
              "transitions": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/transitions"
              }
            }
          }
        ],
        "_links": {
          "self": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows/0"
          },
          "workflows": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows"
          }
        }
      },
      {
        "id": "1",
        "created_at": "2014-11-30T00:00:00+0100",
        "name": "Workflow 2",
        "statuses": [],
        "status_transitions": [],
        "_links": {
          "self": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows/1"
          },
          "workflows": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows"
          }
        }
      },
      {
        "id": "2",
        "created_at": "2014-11-20T00:00:00+0100",
        "name": "Workflow 3",
        "statuses": [],
        "status_transitions": [],
        "_links": {
          "self": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows/2"
          },
          "workflows": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows"
          }
        }
      },
      {
        "id": "3",
        "created_at": "2014-12-30T00:00:00+0100",
        "name": "Workflow 4",
        "statuses": [],
        "status_transitions": [],
        "_links": {
          "self": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows/3"
          },
          "workflows": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows"
          }
        }
      },
      {
        "id": "4",
        "created_at": "2014-09-17T00:00:00+0200",
        "name": "Workflow 5",
        "statuses": [],
        "status_transitions": [],
        "_links": {
          "self": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows/4"
          },
          "workflows": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows"
          }
        }
      },
      {
        "id": "5",
        "created_at": "2014-10-20T00:00:00+0200",
        "name": "Workflow 6",
        "statuses": [],
        "status_transitions": [],
        "_links": {
          "self": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows/5"
          },
          "workflows": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows"
          }
        }
      }]
    """

  Scenario: Getting the 0 workflow
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/workflows/0"
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "created_at": "2014-11-29T00:00:00+0100",
        "name": "Workflow 1",
        "statuses": [
          {
            "type": "normal",
            "name": "Open",
            "id": "0",
            "color": "#27ae60",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/0"
              },
              "statuses": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
              }
            }
          },
          {
            "type": "normal",
            "name": "In progress",
            "id": "1",
            "color": "#2c3e50",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/1"
              },
              "statuses": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
              }
            }
          },
          {
            "type": "normal",
            "name": "Resolved",
            "id": "2",
            "color": "#f1c40f",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/2"
              },
              "statuses": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
              }
            }
          }
        ],
        "status_transitions": [
          {
            "initial_states": [
              {
                "type": "normal",
                "name": "In progress",
                "id": "1",
                "color": "#2c3e50",
                "_links": {
                  "self": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/1"
                  },
                  "statuses": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
                  }
                }
              }
            ],
            "name": "Start progress",
            "id": "0",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/transitions/0"
              },
              "transitions": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/transitions"
              }
            }
          },
          {
            "initial_states": [
              {
                "type": "normal",
                "name": "Open",
                "id": "0",
                "color": "#27ae60",
                "_links": {
                  "self": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/0"
                  },
                  "statuses": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
                  }
                }
              },
              {
                "type": "normal",
                "name": "Resolved",
                "id": "2",
                "color": "#f1c40f",
                "_links": {
                  "self": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/2"
                  },
                  "statuses": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
                  }
                }
              }
            ],
            "name": "Reopen progress",
            "id": "1",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/transitions/1"
              },
              "transitions": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/transitions"
              }
            }
          },
          {
            "initial_states": [
              {
                "type": "normal",
                "name": "Open",
                "id": "0",
                "color": "#27ae60",
                "_links": {
                  "self": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/0"
                  },
                  "statuses": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
                  }
                }
              },
              {
                "type": "normal",
                "name": "In progress",
                "id": "1",
                "color": "#2c3e50",
                "_links": {
                  "self": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses/1"
                  },
                  "statuses": {
                    "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
                  }
                }
              }
            ],
            "name": "Finish progress",
            "id": "2",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/transitions/2"
              },
              "transitions": {
                "href": "http://kreta.test:8000/app_test.php/api/workflows/0/transitions"
              }
            }
          }
        ],
        "_links": {
          "self": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows/0"
          },
          "workflows": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows"
          }
        }
      }
    """

  Scenario: Getting the unknown workflow
    Given I am authenticating with "access-token-0" token
    When I send a GET request to "/api/workflows/unknown-workflow"
    Then the response code should be 404
    And the response should contain json:
    """
      {
        "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Getting the 2 workflow with the user that is not its project participant
    Given I am authenticating with "access-token-1" token
    When I send a GET request to "/api/workflows/2"
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """

  Scenario: Creating a workflow
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/workflows" with body:
    """
      {
        "name": "Dummy Workflow"
      }
    """
    Then the response code should be 201

  Scenario: Creating a workflow without required name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/workflows" with body:
    """
      {
        "name": ""
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "name": [
          "This value should not be blank."
        ]
      }
    """

  Scenario: Creating a workflow with existing name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a POST request to "/api/workflows" with body:
    """
      {
        "name": "Workflow 1"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "name": [
          "A workflow with identical name is already exists"
        ]
      }
    """

  Scenario: Updating a workflow
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/api/workflows/0" with body:
    """
      {
        "name": "New updated Workflow name"
      }
    """
    Then the response code should be 200
    And the response should contain json:
    """
      {
        "id": "0",
        "created_at": "2014-11-29T00:00:00+0100",
        "name": "New updated Workflow name",
        "_links": {
          "self": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows/0"
          },
          "workflows": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows"
          },
          "transitions": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows/0/transitions"
          },
          "statuses": {
            "href": "http://kreta.test:8000/app_test.php/api/workflows/0/statuses"
          }
        }
      }
    """

  Scenario: Updating a workflow without required name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/api/workflows/0" with body:
    """
      {
        "name": ""
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "name": [
          "This value should not be blank."
        ]
      }
    """

  Scenario: Updating a workflow with existing name
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/api/workflows/0" with body:
    """
      {
        "name": "Workflow 2"
      }
    """
    Then the response code should be 400
    And the response should contain json:
    """
      {
        "name": [
          "A workflow with identical name is already exists"
        ]
      }
    """

  Scenario: Updating an unknown workflow
    Given I am authenticating with "access-token-0" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/api/workflows/unknown-workflow" with body:
    """
      {
        "name": "Workflow 1"
      }
    """
    Then the response code should be 404
    And the response should contain json:
    """
      {
          "error": "Does not exist any object with id passed"
      }
    """

  Scenario: Updating 0 workflow with the user that is not workflow creator
    Given I am authenticating with "access-token-1" token
    Given I set header "content-type" with value "application/json"
    When I send a PUT request to "/api/workflows/0" with body:
    """
      {
        "name": "Workflow 1"
      }
    """
    Then the response code should be 403
    And the response should contain json:
    """
      {
        "error": "Not allowed to access this resource"
      }
    """
