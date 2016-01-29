import ActionTypes from '../constants/ActionTypes';

const initialState = {
  project: null,
  fetching: true,
  filters: [],
  issues: [],
  error: false,
  selectedIssue: null
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.CURRENT_PROJECT_FETCHING:
      return { ...state, fetching: true };

    case ActionTypes.CURRENT_PROJECT_RECEIVED:
      return {...state, project: action.project, issues: action.issues, fetching: false};

    case ActionTypes.CURRENT_PROJECT_SELECTED_ISSUE_CHANGED:
      return {...state, selectedIssue: action.selectedIssue};
    default:
      return state;
  }
}
