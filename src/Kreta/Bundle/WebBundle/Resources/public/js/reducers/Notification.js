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
    case ActionTypes.NOTIFICATION_REMOVE:
      const index = state.notifications.findIndex((notification) => {
        return notification.id === action.notification.id;
      });

      if (typeof index < 0) {
        return state;
      }

      return {
        ...state, notifications: [
          ...state.notifications.slice(0, index),
          ...state.notifications.slice(index + 1)
        ]
      };

    // Action listeners
    case ActionTypes.CURRENT_PROJECT_ISSUE_CREATED:
      return _addNotification(state, 'Issue created successfully');

    case ActionTypes.PROJECTS_CREATED:
      return _addNotification(state, 'Project created successfully');

    default:
      return state;
  }
}
