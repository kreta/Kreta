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

const Actions = {
  addNotification: (message, messageType) => dispatch => {
    const id = Math.floor(Math.random() * 1000000);

    setTimeout(() => {
      dispatch({
        type: ActionTypes.NOTIFICATION_REMOVE,
        id,
      });
    }, 5000);

    dispatch({
      type: ActionTypes.NOTIFICATION_ADD,
      notification: {
        id,
        message,
        type: messageType,
      },
    });
  },
  removeNotification: id => ({
    type: ActionTypes.NOTIFICATION_REMOVE,
    id,
  }),
};

export default Actions;
