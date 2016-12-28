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
import OrganizationsQueryRequest from './../api/graphql/query/OrganizationsQueryRequest';
import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';

const Actions = {
  fetchData: () => (dispatch) => {
    dispatch({
      type: ActionTypes.DASHBOARD_DATA_FETCHING
    });

    TaskManagerGraphQl.query([OrganizationsQueryRequest, ProjectsQueryRequest], dispatch);

    OrganizationsQueryRequest.then(organizationsData => {
      ProjectsQueryRequest.then(projectsData => {
        dispatch({
          type: ActionTypes.DASHBOARD_DATA_RECEIVED,
          organizations: organizationsData.response.organizations.edges,
          projects: projectsData.response.projects.edges
        });
      });
    });
  }
};

export default Actions;
