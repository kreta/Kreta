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

import OrganizationsQueryRequest from './../api/graphql/query/OrganizationsQueryRequest';
import ProjectsQueryRequest from './../api/graphql/query/ProjectsQueryRequest';
import TaskManagerGraphQl from './../api/graphql/TaskManagerGraphQl';
import TasksQueryRequest from '../api/graphql/query/TasksQueryRequest';

const Actions = {
  fetchData: query => dispatch => {
    dispatch({
      type: ActionTypes.DASHBOARD_DATA_FETCHING,
    });
    const myOrganizationsQuery = OrganizationsQueryRequest.build({
        name: query,
        organizationsFirst: null,
      }),
      lastUpdatedProjectsQuery = ProjectsQueryRequest.build({name: query}),
      assignedTasksQuery = TasksQueryRequest.build({title: query}),
      queries = [
        myOrganizationsQuery,
        assignedTasksQuery,
        lastUpdatedProjectsQuery,
      ];

    TaskManagerGraphQl.query(queries, dispatch);
    Promise.all(queries).then(data => {
      dispatch({
        type: ActionTypes.DASHBOARD_DATA_RECEIVED,
        myOrganizations: data[0].response.organizations.edges,
        assignedTasks: data[1].response.tasks.edges,
        lastUpdatedProjects: data[2].response.projects.edges,
        searchQuery: query,
      });
    });
  },
};

export default Actions;
