/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// import {routeActions} from 'react-router-redux';

import ActionTypes from './../constants/ActionTypes';

import GraphQlInstance from './../api/graphql/GraphQl';
import ProjectsQueryRequest from './../api/graphql/query/ProjectsQueryRequest';

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
  createProject: () => (dispatch) => {
    dispatch({
      type: ActionTypes.PROJECTS_CREATING
    });
//     ProjectApi.postProject(projectData)
//       .then((response) => {
//         dispatch({
//           type: ActionTypes.PROJECTS_CREATED,
//           status: response.status,
//           project: response.data
//         });
//         dispatch(
//           routeActions.push(`/project/${response.data.id}`)
//         );
//       })
//       .catch((response) => {
//         response.then((errors) => {
//           dispatch({
//             type: ActionTypes.PROJECTS_CREATE_ERROR,
//             status: response.status,
//             errors
//           });
//         });
//       });
  }
};

export default Actions;
