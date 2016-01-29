/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import ActionTypes from '../constants/ActionTypes';
import {routeActions} from 'react-router-redux';

import ProfileApi from './../api/Profile';

const Actions = {
  fetchProfile: () => {
    return dispatch => {
      dispatch({type: ActionTypes.PROFILE_FETCHING});

      ProfileApi.getProfile()
        .then((profile) => {
          dispatch({
            type: ActionTypes.PROFILE_RECEIVED,
            profile: profile
          });
        });
    };
  }
};

export default Actions;
