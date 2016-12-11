/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ProjectApi {
  getProject() {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve({
          status: 200, data: {
            "id": "0",
            "image": {},
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
              },
              {
                "id": "6",
                "name": "symfony"
              },
              {
                "id": "8",
                "name": "css3"
              },
              {
                "id": "9",
                "name": "sass"
              }
            ],
            "name": "Test project 1",
            "participants": [
              {
                "project": null,
                "role": "ROLE_PARTICIPANT",
                "user": {
                  "id": "2",
                  "username": "user3",
                  "email": "user3@kreta.com",
                  "created_at": "2014-10-20T00:00:00+0200",
                  "first_name": "Kreta",
                  "last_name": "User3",
                  "photo": {}
                }
              }
            ],
            "issue_priorities": [
              {
                "id": "0",
                "color": "#969696",
                "name": "Low"
              },
              {
                "id": "1",
                "color": "#67b86a",
                "name": "Medium"
              },
              {
                "id": "2",
                "color": "#f07f2c",
                "name": "High"
              },
              {
                "id": "3",
                "color": "#f02c4c",
                "name": "Blocker"
              }
            ],
            "organization": {
              "id": "0",
              "image": null,
              "name": "Test organization 1",
              "slug": "test-organization-1"
            },
            "slug": "test-project-1",
            "_links": {
              "self": {
                "href": "http://kreta.test:8000/api/projects/0"
              },
              "projects": {
                "href": "http://kreta.test:8000/api/projects"
              },
              "issues": {
                "href": "http://kreta.test:8000/api/issues"
              },
              "labels": {
                "href": "http://kreta.test:8000/api/projects/0/labels"
              },
              "issue_priorities": {
                "href": "http://kreta.test:8000/api/projects/0/issue-priorities"
              },
              "organization": {
                "href": "http://kreta.test:8000/api/organizations/0"
              },
              "workflow": {
                "href": "http://kreta.test:8000/api/workflows/0"
              },
              "statuses": {
                "href": "http://kreta.test:8000/api/workflows/0/statuses"
              },
              "transitions": {
                "href": "http://kreta.test:8000/api/workflows/0/transitions"
              }
            }
          },
        });
      }, 400);
    });
  }
}

const instance = new ProjectApi();

export default instance;
