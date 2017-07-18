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

import ProjectsQueryRequest from './../api/graphql/query/ProjectsQueryRequest';

import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';

const Actions = {
  fetchProjects: () => (dispatch) => {
    dispatch({
      type: ActionTypes.PROJECTS_FETCHING
    });
    TaskManagerGraphQl.query(ProjectsQueryRequest, dispatch);
    ProjectsQueryRequest
      .then(data => {
        dispatch({
          type: ActionTypes.PROJECTS_RECEIVED,
          projects: data.response.projects.edges.map(project => project.node)
        });
      });
  }
};

export default Actions;
