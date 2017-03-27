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

const initialState = {
  fetching: true,
  organization: null,
  potential_members: [],
  projects: []
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.CURRENT_ORGANIZATION_FETCHING: {
      return {...state, fetching: true};
    }
    case ActionTypes.CURRENT_ORGANIZATION_RECEIVED: {
      return {...state, fetching: false, organization: action.organization};
    }

    case ActionTypes.CURRENT_ORGANIZATION_MEMBER_REMOVED : {
      const
        newOrganization = state.organization,
        members = newOrganization.organization_members.filter((member) => member.id !== action.user);

      newOrganization.organization_members = members;

      return {...state, fetching: false, organization: newOrganization};
    }

    case ActionTypes.CURRENT_ORGANIZATION_MEMBER_ADDED : {
      const newOrganization = state.organization;

      newOrganization.organization_members.push(state.potential_members.find((member) => member.id === action.user));

      return {
        ...state,
        fetching: false,
        organization: newOrganization,
        potential_members: state.potential_members.filter(member => member.id !== action.user)
      };
    }

    case ActionTypes.MEMBERS_TO_ADD_RECEIVED: {
      return {...state, fetching: false, potential_members: action.users};
    }

    case ActionTypes.PROJECT_CREATING: {
      return {...state, waiting: true};
    }
    case ActionTypes.PROJECT_CREATED: {
      return {...state, tasks: [...state.projects, action.project], fetching: false};
    }
    case ActionTypes.PROJECT_CREATE_ERROR: {
      return {...state, errors: action.errors};
    }

    default: {
      return state;
    }
  }
}
