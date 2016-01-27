import ActionTypes from '../constants/ActionTypes';

const initialState = {
  projects: [],
  fetching: true,
  error: false,
  selectedRow: 0
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.PROJECTS_FETCHING:
      return { ...state, fetching: true };

    case ActionTypes.PROJECTS_RECEIVED:
      return {...state, projects: action.projects, fetching: false};

    case ActionTypes.PROJECTS_FETCH_ERROR:
      return {...state, error: true};

    default:
      return state;
  }
}
