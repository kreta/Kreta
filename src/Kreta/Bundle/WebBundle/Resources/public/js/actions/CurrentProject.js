/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import ActionTypes from '../constants/ActionTypes';
import {routeActions} from 'react-router-redux';

import IssueApi from './../api/Issue';
import ProjectApi from './../api/Project';

const Actions = {
  fetchProject: (projectId) => {
    return dispatch => {
      dispatch({type: ActionTypes.CURRENT_PROJECT_FETCHING});

      ProjectApi.getProject(projectId)
        .then((project) => {
          dispatch({
            type: ActionTypes.CURRENT_PROJECT_RECEIVED,
            project: project
          });
        });

      IssueApi.getIssues({project: projectId})
        .then((issues) => {
          dispatch({
            type: ActionTypes.CURRENT_PROJECT_ISSUES_RECEIVED,
            issues: issues
          });
        });
    };
  },
  selectCurrentIssue: (issue) => {
    return {
      type: ActionTypes.CURRENT_PROJECT_SELECTED_ISSUE_CHANGED,
      selectedIssue: issue
    };
  },
  filterIssues: (filter) => {

  },
  showSettings: (projectId) => {

  }
};

export default Actions;
