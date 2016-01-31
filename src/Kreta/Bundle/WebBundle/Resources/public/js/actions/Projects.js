/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import ActionTypes from './../constants/ActionTypes';
import {routeActions} from 'react-router-redux';

import ProjectApi from './../api/Project';

const Actions = {
  fetchProjects: () => {
    return (dispatch) => {
      dispatch({type: ActionTypes.PROJECTS_FETCHING});

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
      dispatch({type: ActionTypes.PROJECTS_CREATING});

      ProjectApi.postProject(projectData)
        .then((createdProject) => {
          dispatch({
            type: ActionTypes.PROJECTS_CREATED,
            project: createdProject
          });
          dispatch(
            routeActions.push(`/project/${createdProject.id}`)
          );
        });
    };
  }
};

export default Actions;
