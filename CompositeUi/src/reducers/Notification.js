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
  notifications: [],
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.NOTIFICATION_ADD: {
      return {
        ...state,
        notifications: [...state.notifications, action.notification],
      };
    }

    case ActionTypes.NOTIFICATION_REMOVE: {
      const index = state.notifications.findIndex(
        notification => notification.id === action.id,
      );

      if (typeof index < 0) {
        return state;
      }

      return {
        ...state,
        notifications: [
          ...state.notifications.slice(0, index),
          ...state.notifications.slice(index + 1),
        ],
      };
    }

    default: {
      return state;
    }
  }
}
