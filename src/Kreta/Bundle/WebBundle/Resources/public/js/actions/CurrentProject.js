import ActionTypes              from '../constants/ActionTypes';
import { routeActions }       from 'react-router-redux';

const Actions = {
  fetchProject: (projectId) => {
    return dispatch => {
      dispatch({type: ActionTypes.CURRENT_PROJECT_FETCHING});

      // Simulate API call
      setTimeout(() => {
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_RECEIVED,
          project: {
            'id': '0',
            'image': {
              'id': '0',
              'created_at': '2014-10-30T00:00:00+0100',
              'name': 'http://kreta.test:8000/media/image/project-1.jpg',
              'updated_at': null
            },
            'labels': [
              {
                'id': '0',
                'name': 'backbone.js'
              },
              {
                'id': '11',
                'name': 'mysql'
              },
              {
                'id': '12',
                'name': 'mongodb'
              },
              {
                'id': '2',
                'name': 'javascript'
              },
              {
                'id': '3',
                'name': 'bdd'
              },
              {
                'id': '6',
                'name': 'symfony'
              },
              {
                'id': '8',
                'name': 'css3'
              },
              {
                'id': '9',
                'name': 'sass'
              }
            ],
            'name': 'Test project 1',
            'participants': [
              {
                'project': null,
                'role': 'ROLE_ADMIN',
                'user': {
                  'id': '0',
                  'username': 'user',
                  'email': 'user@kreta.com',
                  'created_at': '2014-10-20T00:00:00+0200',
                  'first_name': 'Kreta',
                  'last_name': 'User',
                  'photo': null
                }
              },
              {
                'project': null,
                'role': 'ROLE_PARTICIPANT',
                'user': {
                  'id': '2',
                  'username': 'user3',
                  'email': 'user3@kreta.com',
                  'created_at': '2014-10-20T00:00:00+0200',
                  'first_name': 'Kreta',
                  'last_name': 'User3',
                  'photo': {
                    'id': '3',
                    'created_at': '2014-10-30T00:00:00+0100',
                    'name': 'http://kreta.test:8000/media/image/user-3.jpg',
                    'updated_at': null
                  }
                }
              }
            ],
            'issue_priorities': [
              {
                'id': '0',
                'name': 'Low',
                'color': '#969696'
              },
              {
                'id': '1',
                'name': 'Medium',
                'color': '#67b86a'
              },
              {
                'id': '2',
                'name': 'High',
                'color': '#f07f2c'
              },
              {
                'id': '3',
                'name': 'Blocker',
                'color': '#f02c4c'
              }
            ],
            'short_name': 'TPR1',
            'workflow': {
              'id': '0',
              'name': 'Workflow 1'
            }
          },
          issues: [{
            'id': '0',
            'assignee': {
              'id': '0',
              'username': 'user',
              'email': 'user@kreta.com',
              'first_name': 'Kreta',
              'last_name': 'User',
              'photo': null
            },
            'children': [],
            'created_at': '2014-12-15T00:00:00+0100',
            'description': 'Description',
            'labels': [
              {
                'id': '0',
                'name': 'backbone.js'
              },
              {
                'id': '2',
                'name': 'javascript'
              },
              {
                'id': '3',
                'name': 'bdd'
              },
              {
                'id': '6',
                'name': 'symfony'
              },
              {
                'id': '8',
                'name': 'css3'
              }
            ],
            'numeric_id': 1,
            'parent': null,
            'priority': {
              'id': '1',
              'name': 'Medium',
              'color': '#67b86a'
            },
            'resolution': null,
            'reporter': {
              'id': '0',
              'username': 'user',
              'email': 'user@kreta.com',
              'first_name': 'Kreta',
              'last_name': 'User',
              'photo': null
            },
            'status': {
              'type': 'normal',
              'name': 'Open',
              'id': '0',
              'color': '#27ae60'
            },
            'title': 'Test issue 1',
            '_links': {
              'self': {
                'href': 'http://kreta.test:8000/api/issues/0'
              },
              'project': {
                'href': 'http://kreta.test:8000/api/projects/0'
              },
              'issues': {
                'href': 'http://kreta.test:8000/api/issues'
              }
            }
          }]
        });
      }, 200);
    };
  },
  selectCurrentIssue: (issue) => {
    return {
      type: ActionTypes.CURRENT_PROJECT_SELECTED_ISSUE_CHANGED,
      selectedIssue: issue
    };
  },
  createIssue: (issue) => {
    return dispatch => {
      dispatch({type: ActionTypes.CURRENT_PROJECT_ISSUE_CREATING});

      setTimeout(() => {
        issue.id = Math.floor((Math.random() * 100000) + 1);
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_ISSUE_CREATED,
          issue: issue
        });
        dispatch(
          routeActions.push(`/project/${issue.project}/issue/${issue.id}`)
        );
      }, 200);
    }
  },
  filterIssues: (filter) => {

  }
};

export default Actions;
