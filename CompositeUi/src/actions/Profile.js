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
import ProfileApi from './../api/Profile';

const Actions = {
  fetchProfile: () => (dispatch) => {
    dispatch({
      type: ActionTypes.PROFILE_FETCHING
    });
    ProfileApi.getProfile()
      .then((response) => {
        dispatch({
          type: ActionTypes.PROFILE_RECEIVED,
          profile: response.data,
          status: response.status
        });
      });
  },
  updateProfile: (profileData) => (dispatch) => {
    dispatch({
      type: ActionTypes.PROFILE_UPDATE
    });
    ProfileApi.putProfile(profileData)
      .then((response) => {
        dispatch({
          type: ActionTypes.PROFILE_UPDATED,
          status: response.status,
          profile: response.data
        });
      })
      .catch((response) => {
        response.then((errors) => {
          dispatch({
            type: ActionTypes.PROFILE_UPDATE_ERROR,
            status: response.status,
            errors
          });
        });
      });
  }
};

export default Actions;
