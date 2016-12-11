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

import GraphQlInstance from './../api/graphql/GraphQl';
import ProjectsQueryRequest from './../api/graphql/query/ProjectsQueryRequest';
import CreateProjectMutationRequest from './../api/graphql/mutation/CreateProjectMutationRequest';

const Actions = {
  fetchProjects: () => (dispatch) => {
    dispatch({
      type: ActionTypes.PROJECTS_FETCHING
    });
    GraphQlInstance.query(ProjectsQueryRequest);
    ProjectsQueryRequest.then(data => {
      dispatch({
        type: ActionTypes.PROJECTS_RECEIVED,
        projects: data.response.projects.edges
      });
    });
  },
  createProject: (projectInputData) => (dispatch) => {
    dispatch({
      type: ActionTypes.PROJECTS_CREATING
    });
    const mutation = CreateProjectMutationRequest.build(projectInputData);

    GraphQlInstance.mutation(mutation);
    mutation
      .then(data => {
        const project = data.response.createProject.project;

        dispatch({
          type: ActionTypes.PROJECTS_CREATED,
          project,
        });
        dispatch(
          routeActions.push(`/project/${project.id}`)
        );
      })
      .catch((response) => {
        response.then((errors) => {
          dispatch({
            type: ActionTypes.PROJECTS_CREATE_ERROR,
            errors
          });
        });
      });
  }
};

export default Actions;
