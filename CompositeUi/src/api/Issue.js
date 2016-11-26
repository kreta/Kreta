/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Api from './Api';

class IssueApi extends Api {
  getIssues() {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve([
          {
            "id": "0",
            "assignee": {
              "id": "0",
              "username": "user",
              "email": "user@kreta.com",
              "first_name": "Kreta",
              "last_name": "User",
              "photo": null
            },
            "children": [],
            "created_at": "2014-12-15T00:00:00+0100",
            "description": "Description",
            "labels": [
              {
                "id": "0",
                "name": "backbone.js"
              },
              {
                "id": "2",
                "name": "javascript"
              },
              {
                "id": "3",
                "name": "bdd"
              },
              {
                "id": "6",
                "name": "symfony"
              },
              {
                "id": "8",
                "name": "css3"
              }
            ],
            "numeric_id": 1,
            "parent": null,
            "priority": {
              "id": "1",
              "name": "Medium",
              "color": "#67b86a"
            },
            "resolution": null,
            "reporter": {
              "id": "0",
              "username": "user",
              "email": "user@kreta.com",
              "first_name": "Kreta",
              "last_name": "User",
              "photo": null
            },
            "status": {
              "type": "normal",
              "name": "Open",
              "id": "0",
              "color": "#27ae60"
            },
            "title": "Test issue 1",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/api/issues/0"
              },
              "project": {
                "href": "http://kreta.test:8000/api/projects/0"
              },
              "issues": {
                "href": "http://kreta.test:8000/api/issues"
              }
            }
          },
          {
            "id": "1",
            "assignee": {
              "id": "0",
              "username": "user",
              "email": "user@kreta.com",
              "first_name": "Kreta",
              "last_name": "User",
              "photo": null
            },
            "children": [],
            "created_at": "2014-11-07T00:00:00+0100",
            "description": "Description",
            "labels": [
              {
                "id": "0",
                "name": "backbone.js"
              },
              {
                "id": "2",
                "name": "javascript"
              },
              {
                "id": "3",
                "name": "bdd"
              },
              {
                "id": "6",
                "name": "symfony"
              },
              {
                "id": "8",
                "name": "css3"
              }
            ],
            "numeric_id": 2,
            "parent": null,
            "priority": {
              "id": "0",
              "name": "Low",
              "color": "#969696"
            },
            "resolution": null,
            "reporter": {
              "id": "0",
              "username": "user",
              "email": "user@kreta.com",
              "first_name": "Kreta",
              "last_name": "User",
              "photo": null
            },
            "status": {
              "type": "normal",
              "name": "Resolved",
              "id": "2",
              "color": "#f1c40f"
            },
            "title": "Test issue 2",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/api/issues/1"
              },
              "project": {
                "href": "http://kreta.test:8000/api/projects/0"
              },
              "issues": {
                "href": "http://kreta.test:8000/api/issues"
              }
            }
          },
          {
            "id": "2",
            "assignee": {
              "id": "0",
              "username": "user",
              "email": "user@kreta.com",
              "first_name": "Kreta",
              "last_name": "User",
              "photo": null
            },
            "children": [],
            "created_at": "2014-10-21T00:00:00+0200",
            "description": "Description",
            "labels": [
              {
                "id": "0",
                "name": "backbone.js"
              },
              {
                "id": "11",
                "name": "mysql"
              },
              {
                "id": "12",
                "name": "mongodb"
              },
              {
                "id": "2",
                "name": "javascript"
              },
              {
                "id": "3",
                "name": "bdd"
              }
            ],
            "numeric_id": 3,
            "parent": null,
            "priority": {
              "id": "2",
              "name": "High",
              "color": "#f07f2c"
            },
            "resolution": null,
            "reporter": {
              "id": "0",
              "username": "user",
              "email": "user@kreta.com",
              "first_name": "Kreta",
              "last_name": "User",
              "photo": null
            },
            "status": {
              "type": "normal",
              "name": "Resolved",
              "id": "2",
              "color": "#f1c40f"
            },
            "title": "Test issue 3",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/api/issues/2"
              },
              "project": {
                "href": "http://kreta.test:8000/api/projects/0"
              },
              "issues": {
                "href": "http://kreta.test:8000/api/issues"
              }
            }
          },
          {
            "id": "5",
            "assignee": {
              "id": "0",
              "username": "user",
              "email": "user@kreta.com",
              "first_name": "Kreta",
              "last_name": "User",
              "photo": null
            },
            "children": [],
            "created_at": "2014-10-21T00:00:00+0200",
            "description": "Description",
            "labels": [
              {
                "id": "0",
                "name": "backbone.js"
              },
              {
                "id": "11",
                "name": "mysql"
              },
              {
                "id": "12",
                "name": "mongodb"
              },
              {
                "id": "2",
                "name": "javascript"
              },
              {
                "id": "3",
                "name": "bdd"
              }
            ],
            "numeric_id": 4,
            "parent": null,
            "priority": {
              "id": "3",
              "name": "Blocker",
              "color": "#f02c4c"
            },
            "resolution": null,
            "reporter": {
              "id": "1",
              "username": "user2",
              "email": "user2@kreta.com",
              "first_name": "Kreta",
              "last_name": "User2",
              "photo": {
                "id": "2",
                "name": "http://kreta.test:8000/media/image/user-2.jpg"
              }
            },
            "status": {
              "type": "normal",
              "name": "Closed",
              "id": "3",
              "color": "#c0392b"
            },
            "title": "Test issue 4",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/api/issues/5"
              },
              "project": {
                "href": "http://kreta.test:8000/api/projects/0"
              },
              "issues": {
                "href": "http://kreta.test:8000/api/issues"
              }
            }
          }
        ]);
      }, 400);
    });
  }

  getIssue() {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve({
          "id": "0",
          "assignee": {
            "id": "0",
            "username": "user",
            "email": "user@kreta.com",
            "first_name": "Kreta",
            "last_name": "User",
            "photo": null
          },
          "children": [],
          "created_at": "2014-12-15T00:00:00+0100",
          "description": "Description",
          "labels": [
            {
              "id": "0",
              "name": "backbone.js"
            },
            {
              "id": "2",
              "name": "javascript"
            },
            {
              "id": "3",
              "name": "bdd"
            },
            {
              "id": "6",
              "name": "symfony"
            },
            {
              "id": "8",
              "name": "css3"
            }
          ],
          "numeric_id": 1,
          "parent": null,
          "priority": {
            "id": "1",
            "name": "Medium",
            "color": "#67b86a"
          },
          "resolution": null,
          "reporter": {
            "id": "0",
            "username": "user",
            "email": "user@kreta.com",
            "first_name": "Kreta",
            "last_name": "User",
            "photo": null
          },
          "status": {
            "type": "normal",
            "name": "Open",
            "id": "0",
            "color": "#27ae60"
          },
          "title": "Test issue 1",
          "_links": {
            "self": {
              "href": "http://kreta.test:8000/api/issues/0"
            },
            "project": {
              "href": "http://kreta.test:8000/api/projects/0"
            },
            "issues": {
              "href": "http://kreta.test:8000/api/issues"
            }
          }
        });
      }, 400);
    });
  }

  postIssue(payload) {
    return this.post('/issues', payload);
  }

  putIssue(issueId, payload) {
    return this.put(`/issues/${issueId}`, payload);
  }
}

const instance = new IssueApi();

export default instance;
