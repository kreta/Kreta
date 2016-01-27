import ActionTypes from '../constants/ActionTypes';

const initialState = {
  profile: null,
  fetching: false,
  error: false
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.PROFILE_FETCHING:
      return { ...state, fetching: true };

    case ActionTypes.PROFILE_RECEIVED:
      return {...state, profile: action.profile, fetching: false};

    case ActionTypes.PROFILE_FETCH_ERROR:
      return {...state, error: true};

    default:
      return state;
  }
}
