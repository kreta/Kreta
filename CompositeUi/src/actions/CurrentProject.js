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

import ActionTypes from './../constants/ActionTypes';
import IssueApi from './../api/Issue';
import ProjectQueryRequest from './../api/graphql/query/ProjectQueryRequest';
import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';

const Actions = {
  fetchProject: (projectId) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_FETCHING
    });
    const query = ProjectQueryRequest.build(projectId);

    TaskManagerGraphQl.query(query);
    query.then(data => {
      dispatch({
        type: ActionTypes.CURRENT_PROJECT_RECEIVED,
        project: data.response.project,
      });
    });
  },
  selectCurrentIssue: (issue) => {
    if (typeof issue === 'object' || issue === null) {
      return {
        type: ActionTypes.CURRENT_PROJECT_SELECTED_ISSUE_CHANGED,
        selectedIssue: issue
      };
    }

    return (dispatch) => {
      dispatch({
        type: ActionTypes.CURRENT_PROJECT_SELECTED_ISSUE_FETCHING
      });
      IssueApi.getIssue(issue)
        .then((response) => {
          dispatch({
            type: ActionTypes.CURRENT_PROJECT_SELECTED_ISSUE_CHANGED,
            selectedIssue: response.data,
            status: response.status
          });
        });
    };
  },
  createIssue: (issueData) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_ISSUE_CREATING
    });
    IssueApi.postIssue(issueData)
      .then((response) => {
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_ISSUE_CREATED,
          status: response.status,
          issue: response.data
        });
        dispatch(
          routeActions.push(`/project/${response.data.project}/issue/${response.data.id}`)
        );
      })
      .catch((response) => {
        response.then((errors) => {
          dispatch({
            type: ActionTypes.CURRENT_PROJECT_ISSUE_CREATE_ERROR,
            status: response.status,
            errors
          });
        });
      });
  },
  updateIssue: (issueData) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_ISSUE_UPDATE
    });
    IssueApi.putIssue(issueData.id, issueData)
      .then((response) => {
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_ISSUE_UPDATED,
          status: response.status,
          issue: response.data
        });
      })
      .catch((response) => {
        response.then((errors) => {
          dispatch({
            type: ActionTypes.CURRENT_PROJECT_ISSUE_UPDATE_ERROR,
            status: response.status,
            errors
          });
        });
      });
  },
  filterIssues: (filter) => (dispatch) => {
    dispatch({
      type: ActionTypes.CURRENT_PROJECT_ISSUE_FILTERING
    });
    IssueApi.getIssues(filter)
      .then((response) => {
        dispatch({
          type: ActionTypes.CURRENT_PROJECT_ISSUE_FILTERED,
          filter: response.data,
          status: response.status
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
