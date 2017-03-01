/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {routeActions} from 'react-router-redux';

import {routes} from './../Routes';

import ActionTypes from './../constants/ActionTypes';
import TaskApi from './../api/Task';
import TasksQueryRequest from './../api/graphql/query/TasksQueryRequest';
import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';
import Users from './../api/rest/User/Users';

const Actions = {
  fetchProject: (organizationSlug, projectSlug) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_FETCHING
    });

    const project = {
      id: '1',
      name: 'Dummy Project',
      slug: projectSlug,
      organization: {
        id: '1',
        name: 'Dummy Organization',
        slug: organizationSlug,
        organization_members: [
          {
            "id": "8eb29ed7-93b2-4c94-bb9b-ad4b323ad8c5"
          },
          {
            "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
          }
        ],
        owners: [
          {
            "id": "da49c01f-2e99-45ee-9557-eb3eb57b06c5"
          }
        ]
      },
      _tasks4hn9we: {
        edges: [
          {
            "node": {
              "id": "006cea59-2e99-463c-81e0-181aca8b5689",
              "title": "Task 6",
              "description": "The description of the task 6",
              "progress": "TODO",
              "priority": "HIGH",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "01b9b656-a488-417e-9bad-cebc3cf970a7",
              "title": "Task 8",
              "description": "The description of the task 8",
              "progress": "TODO",
              "priority": "HIGH",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "12a6939f-9602-4f8b-8beb-ad8a580239b7",
              "title": "Task 22",
              "description": "The description of the task 22",
              "progress": "TODO",
              "priority": "MEDIUM",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "199b8f0a-b9ae-4ad6-ab7f-732527fc64d5",
              "title": "Task 4",
              "description": "The description of the task 4",
              "progress": "TODO",
              "priority": "HIGH",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "275cf305-b9d2-480d-b081-96285f581c99",
              "title": "Task 27",
              "description": "The description of the task 27",
              "progress": "TODO",
              "priority": "HIGH",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "363a58a5-9a40-4c22-aab2-54cd28f7b962",
              "title": "Task 28",
              "description": "The description of the task 28",
              "progress": "TODO",
              "priority": "LOW",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "566fad18-ed9c-4707-b901-d5c4f8739344",
              "title": "Task 31",
              "description": "The description of the task 31",
              "progress": "TODO",
              "priority": "LOW",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "6260fee5-eef2-461d-b84c-be7fec3c374c",
              "title": "Task 44",
              "description": "The description of the task 44",
              "progress": "TODO",
              "priority": "MEDIUM",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "67895114-3561-418a-8442-9412ab4e2324",
              "title": "Task 13",
              "description": "The description of the task 13",
              "progress": "TODO",
              "priority": "LOW",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "67e28b29-b6b6-4dbc-a89d-b1971e6bd1fa",
              "title": "Task 42",
              "description": "The description of the task 42",
              "progress": "TODO",
              "priority": "MEDIUM",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "6b82815a-e08d-4c9b-afde-ee937e932695",
              "title": "Task 47",
              "description": "The description of the task 47",
              "progress": "TODO",
              "priority": "HIGH",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "707c1f0e-ad6f-431c-ae2a-f7a6b9f4ed14",
              "title": "Task 0",
              "description": "The description of the task 0",
              "progress": "TODO",
              "priority": "MEDIUM",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "7e8dbbc0-1607-475d-9b05-c9f7a2cb0a0c",
              "title": "Task 17",
              "description": "The description of the task 17",
              "progress": "TODO",
              "priority": "HIGH",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "a0be17da-8b2d-406b-8ff1-93afbb4664fe",
              "title": "Task 46",
              "description": "The description of the task 46",
              "progress": "TODO",
              "priority": "MEDIUM",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "a59fe03e-6ec1-4113-9a48-c6d0a30f1046",
              "title": "Task 36",
              "description": "The description of the task 36",
              "progress": "TODO",
              "priority": "LOW",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "ac11b8b7-3889-446b-aa8c-6f864f4be710",
              "title": "Task 48",
              "description": "The description of the task 48",
              "progress": "TODO",
              "priority": "MEDIUM",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "ba2ae5d9-2d2b-4f2b-8b93-ff08ff324fcd",
              "title": "Task 33",
              "description": "The description of the task 33",
              "progress": "TODO",
              "priority": "MEDIUM",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "c2d88924-9497-447e-b4e7-1ce5e163953b",
              "title": "Task 35",
              "description": "The description of the task 35",
              "progress": "TODO",
              "priority": "HIGH",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "cd768a92-3eaa-4dcb-a4ff-6be6b9fd3255",
              "title": "Task 21",
              "description": "The description of the task 21",
              "progress": "TODO",
              "priority": "HIGH",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "cfaf6df0-eba7-454f-ba0c-9917631c9667",
              "title": "Task 40",
              "description": "The description of the task 40",
              "progress": "TODO",
              "priority": "HIGH",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "d02efb23-6a02-440f-a899-4a7f030f0505",
              "title": "Task 41",
              "description": "The description of the task 41",
              "progress": "TODO",
              "priority": "HIGH",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "d0d7f872-6b4e-4405-80d8-0fa61d1a4e7c",
              "title": "Task 18",
              "description": "The description of the task 18",
              "progress": "TODO",
              "priority": "MEDIUM",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "e75adef8-a770-4c13-b584-d2324d1be112",
              "title": "Task 16",
              "description": "The description of the task 16",
              "progress": "TODO",
              "priority": "LOW",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "f522a933-2afe-408e-b837-01f35e5f7c5c",
              "title": "Task 11",
              "description": "The description of the task 11",
              "progress": "TODO",
              "priority": "HIGH",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          },
          {
            "node": {
              "id": "f62400f3-a90a-4152-a572-f1f29a3fd7c3",
              "title": "Task 39",
              "description": "The description of the task 39",
              "progress": "TODO",
              "priority": "MEDIUM",
              "assignee": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              },
              "creator": {
                "id": "a38f8ef4-400b-4229-a5ff-712ff5f72b27"
              }
            }
          }
        ]
      }
    };

    const loadUsers = (arrays) => {
      const ids = [];
      arrays.forEach((user) => {
        ids.push(user.id);
      });

      Users.get({ids}).then((users) => {
        arrays.forEach((user, index) => {
          const found = users.find((it) => it.id === user.id);
          if (found) {
            Object.assign(arrays[index], found);
          }
        });
      });
    };

    const members = [];

    project._tasks4hn9we.edges.map((task) => {
      members.push(task.node.assignee);
      members.push(task.node.creator);
    });

    loadUsers([
      ...project.organization.organization_members,
      ...project.organization.owners,
      ...members
    ], project);

    dispatch({
      type: ActionTypes.CURRENT_PROJECT_RECEIVED,
      project,
    });

    // const query = ProjectQueryRequest.build(projectId);
    //
    // TaskManagerGraphQl.query(query, dispatch);
    // query
    //   .then(data => {
    //     dispatch({
    //       type: ActionTypes.CURRENT_PROJECT_RECEIVED,
    //       project: data.response.project,
    //     });
    //   });
  },
  selectCurrentTask: (task) => (dispatch) => (
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_SELECTED_TASK_CHANGED,
      selectedTask: task
    })
  ),
  loadFilters: (assignee) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_FILTERS_LOADED,
      assignee
    });
  },
  filterTasks: (filters) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_FILTERING
    });
    const query = TasksQueryRequest.build(filters);

    TaskManagerGraphQl.query(query, dispatch);
    query.then(data => {
      dispatch({
        type: ActionTypes.CURRENT_PROJECT_TASK_FILTERED,
        tasks: data.response.tasks,
      });
    });
  },
  createTask: (taskData) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_CREATING
    });
    TaskApi.postTask(taskData)
      .then((task) => {
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_TASK_CREATED,
          task
        });
        dispatch(
          routeActions.push(routes.task.show(task.project.organization.slug, task.project.slug, task.id))
        );
      })
      .catch((response) => {
        response.then((errors) => {
          dispatch({
            type: ActionTypes.CURRENT_PROJECT_TASK_CREATE_ERROR,
            status: response.status,
            errors
          });
        });
      });
  },
  updateTask: (taskData) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_TASK_UPDATE
    });
    TaskApi.putTask(taskData.id, taskData)
      .then((response) => {
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_TASK_UPDATED,
          status: response.status,
          task: response.data
        });
      })
      .catch((response) => {
        response.then((errors) => {
          dispatch({
            type: ActionTypes.CURRENT_PROJECT_TASK_UPDATE_ERROR,
            status: response.status,
            errors
          });
        });
      });
  },
  addParticipant: (user) => (dispatch) => {
    const participant = {
      role: 'ROLE_PARTICIPANT',
      user
    };

    setTimeout(() => {
      dispatch({
        type: ActionTypes.CURRENT_PROJECT_PARTICIPANT_ADDED,
        participant
      });
    });
  }
};

export default Actions;
