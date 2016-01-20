/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import ActionTypes from '../constants/ActionTypes'
import AppDispatcher from '../dispatcher/AppDispatcher';

export function profileUpdate(profile) {
  AppDispatcher.dispatch({
    type: ActionTypes.PROFILE_UPDATE,
    profile: profile
  })
}
