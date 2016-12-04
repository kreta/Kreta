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
import ProjectApi from './../api/Project';

const Actions = {
  fetchProjects: () => (dispatch) => {
    dispatch({
      type: ActionTypes.PROJECTS_FETCHING
    });
    ProjectApi.getProjects()
      .then((response) => {
        dispatch({
          type: ActionTypes.PROJECTS_RECEIVED,
          status: response.status,
          projects: response.data
        });
      });
  },
  createProject: (projectData) => (dispatch) => {
    dispatch({
      type: ActionTypes.PROJECTS_CREATING
    });
    ProjectApi.postProject(projectData)
      .then((response) => {
        dispatch({
          type: ActionTypes.PROJECTS_CREATED,
          status: response.status,
          project: response.data
        });
        dispatch(
          routeActions.push(`/project/${response.data.id}`)
        );
      })
      .catch((response) => {
        response.then((errors) => {
          dispatch({
            type: ActionTypes.PROJECTS_CREATE_ERROR,
            status: response.status,
            errors
          });
        });
      });
  }
};

export default Actions;
