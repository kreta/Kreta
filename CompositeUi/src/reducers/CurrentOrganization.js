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
  updating: false,
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

    case ActionTypes.CURRENT_ORGANIZATION_MEMBER_REMOVED: {
      const index = state.organization.organization_members.findIndex(member => member.id === action.userId);

      return {
        ...state,
        fetching: false,
        organization: {
          ...state.organization, organization_members: [
            ...state.organization.organization_members.slice(0, index),
            ...state.organization.organization_members.slice(index + 1)
          ]
        },
        potential_members: [
          ...state.potential_members,
          state.organization.organization_members[index]
        ]
      };
    }
    case ActionTypes.CURRENT_ORGANIZATION_MEMBER_REMOVE_ERROR: {
      return {...state, fetching: false};
    }

    case ActionTypes.CURRENT_ORGANIZATION_MEMBER_ADDED: {
      const index = state.potential_members.findIndex(member => member.id === action.userId);

      return {
        ...state,
        fetching: false,
        organization: {
          ...state.organization,
          organization_members: [
            ...state.organization.organization_members,
            state.potential_members[index]
          ]
        },
        potential_members: [
          ...state.potential_members.slice(0, index),
          ...state.potential_members.slice(index + 1)
        ]
      };
    }
    case ActionTypes.CURRENT_ORGANIZATION_MEMBER_ADD_ERROR: {
      return {...state, fetching: false};
    }

    case ActionTypes.MEMBERS_TO_ADD_RECEIVED: {
      return {...state, fetching: false, potential_members: action.users};
    }

    case ActionTypes.PROJECT_CREATING: {
      return {...state, updating: true};
    }

    case ActionTypes.PROJECT_CREATED: {
      return {...state, tasks: [...state.projects, action.project], updating: false};
    }

    case ActionTypes.PROJECT_CREATE_ERROR: {
      return {...state, errors: action.errors, updating: false};
    }

    case ActionTypes.PROJECT_EDITING: {
      return {...state, updating: true};
    }

    case ActionTypes.PROJECT_EDITED:
    case ActionTypes.PROJECT_EDIT_ERROR: {
      return {...state, updating: false};
    }

    default: {
      return state;
    }
  }
}
