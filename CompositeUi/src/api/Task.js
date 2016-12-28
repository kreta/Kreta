/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class TaskApi {
  getTasks() {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve({status: 200, data: [
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
            "title": "Test task 1",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/api/tasks/0"
              },
              "project": {
                "href": "http://kreta.test:8000/api/projects/0"
              },
              "tasks": {
                "href": "http://kreta.test:8000/api/tasks"
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
            "title": "Test task 2",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/api/tasks/1"
              },
              "project": {
                "href": "http://kreta.test:8000/api/projects/0"
              },
              "tasks": {
                "href": "http://kreta.test:8000/api/tasks"
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
            "title": "Test task 3",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/api/tasks/2"
              },
              "project": {
                "href": "http://kreta.test:8000/api/projects/0"
              },
              "tasks": {
                "href": "http://kreta.test:8000/api/tasks"
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
            "title": "Test task 4",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/api/tasks/5"
              },
              "project": {
                "href": "http://kreta.test:8000/api/projects/0"
              },
              "tasks": {
                "href": "http://kreta.test:8000/api/tasks"
              }
            }
          }
        ]});
      }, 400);
    });
  }

  getTask() {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve({status: 200, data: {
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
          "title": "Test task 1",
          "_links": {
            "self": {
              "href": "http://kreta.test:8000/api/tasks/0"
            },
            "project": {
              "href": "http://kreta.test:8000/api/projects/0"
            },
            "tasks": {
              "href": "http://kreta.test:8000/api/tasks"
            }
          }
        }});
      }, 400);
    });
  }

//   postTask(payload) {
//     return this.post('/tasks', payload);
//   }
//
//   putTask(taskId, payload) {
//     return this.put(`/tasks/${taskId}`, payload);
//   }
}

const instance = new TaskApi();

export default instance;
