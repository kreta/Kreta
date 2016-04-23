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
  fetchProjects: () => {
    return (dispatch) => {
      dispatch({
        type: ActionTypes.PROJECTS_FETCHING
      });
      ProjectApi.getProjects()
        .then((projects) => {
          dispatch({
            type: ActionTypes.PROJECTS_RECEIVED,
            projects
          });
        });
    };
  },
  createProject: (projectData) => {
    return (dispatch) => {
      dispatch({
        type: ActionTypes.PROJECTS_CREATING
      });
      ProjectApi.postProject(projectData)
        .then((createdProject) => {
          dispatch({
            type: ActionTypes.PROJECTS_CREATED,
            project: createdProject
          });
          dispatch(
            routeActions.push(`/${createdProject.organization.slug}/${createdProject.slug}`)
          );
        })
        .catch((errorData) => {
          errorData.then((errors) => {
            dispatch({
              type: ActionTypes.PROJECTS_CREATE_ERROR,
              errors
            });
          });
        });
    };
  },
  updateProject: (projectId, projectData) => {
    return (dispatch) => {
      dispatch({
        type: ActionTypes.PROJECTS_UPDATING
      });
      ProjectApi.putProject(projectId, projectData)
        .then((updatedProject) => {
          dispatch({
            type: ActionTypes.PROJECTS_UPDATED,
            project: updatedProject
          });
          dispatch(
            routeActions.push(`/${updatedProject.organization.slug}/${updatedProject.slug}/settings`)
          );
        })
        .catch((errorData) => {
          errorData.then((errors) => {
            dispatch({
              type: ActionTypes.PROJECTS_UPDATE_ERROR,
              errors
            });
          });
        });
    };
  }
};

export default Actions;
