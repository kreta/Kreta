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
  notifications: []
};

function _addNotification(state, message, type = 'success') {
  return {
    ...state,
    notifications: [
      ...state.notifications, {
        id: Math.floor((Math.random() * 1000000)),
        message,
        type
      }
    ]
  };
}
export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.NOTIFICATION_REMOVE: {
      const index = state.notifications.findIndex(notification => notification.id === action.notification.id);

      if (typeof index < 0) {
        return state;
      }

      return {
        ...state, notifications: [
          ...state.notifications.slice(0, index),
          ...state.notifications.slice(index + 1)
        ]
      };
    }

    // Action listeners
    case ActionTypes.TASK_UPDATED: {
      return _addNotification(state, 'Task updated successfully');
    }

    case ActionTypes.PROFILE_UPDATED: {
      return _addNotification(state, 'Profile updated successfully');
    }

    case ActionTypes.PROFILE_UPDATE_ERROR: {
      return _addNotification(state, 'The profile update failed, please check field errors', 'error');
    }

    case ActionTypes.CURRENT_PROJECT_TASK_CREATED: {
      return _addNotification(state, 'Task created successfully');
    }

    case ActionTypes.PROJECTS_CREATED: {
      return _addNotification(state, 'Project created successfully');
    }

    case ActionTypes.ORGANIZATION_CREATED: {
      return _addNotification(state, 'Organization created successfully');
    }
    case ActionTypes.ORGANIZATION_CREATE_ERROR: {
      const
        notifications = state.notifications,
        currentNotifications = action.errors.map((error) => (
          {
            id: Math.floor((Math.random() * 1000000)),
            message: error.message,
            type: 'error'
          }
        ));

      return {
        ...state, notifications: notifications.concat(currentNotifications)
      };
    }

    case ActionTypes.USER_AUTHORIZATION_ERROR: {
      return _addNotification(state, 'Invalid credentials', 'error');
    }

    case ActionTypes.USER_RESTORED_PASSWORD: {
      return _addNotification(state, 'Change password process is successfully done');
    }
    case ActionTypes.USER_RESET_PASSWORD_ERROR: {
      return _addNotification(state, 'The remember password token is invalid', 'error');
    }

    case ActionTypes.USER_REGISTERED: {
      return _addNotification(
        state,
        'Registration process has been successfully done. Check your email inbox to enable the account'
      );
    }
    case ActionTypes.USER_REGISTER_ERROR: {
      return _addNotification(state, 'The email is already in use', 'error');
    }

    case ActionTypes.USER_ENABLED: {
      return _addNotification(
        state,
        'Your account is successfully enabled. Now, you can try to login with your credentials'
      );
    }

    case ActionTypes.USER_AUTHORIZED: {
      return {...state, notifications: []};
    }

    default: {
      return state;
    }
  }
}
