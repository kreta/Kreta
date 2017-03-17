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
import Profile from './../api/rest/User/Profile';
import UserActions from './User';

const Actions = {
  fetchProfile: () => (dispatch) => {
    dispatch({
      type: ActionTypes.PROFILE_FETCHING
    });
    Profile.get()
      .then((response) => {
        dispatch({
          type: ActionTypes.PROFILE_RECEIVED,
          profile: response
        });
      })
      .catch(() => (dispatch(UserActions.logout())));
  },
  updateProfile: (profileData) => (dispatch) => {
    dispatch({
      type: ActionTypes.PROFILE_UPDATE
    });
    Profile.update(profileData)
      .then((response) => {
        dispatch({
          type: ActionTypes.PROFILE_UPDATED,
          profile: response
        });

        // Hack to maintain the session in the React
        // app if the user changes the email
        localStorage.token = response.token;
      })
      .catch((response) => {
        response.then((errors) => {
          dispatch({
            type: ActionTypes.PROFILE_UPDATE_ERROR,
            errors
          });
        });
      });
  }
};

export default Actions;
