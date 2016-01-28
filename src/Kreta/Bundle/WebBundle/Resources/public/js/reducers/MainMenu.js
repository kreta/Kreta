import ActionTypes from '../constants/ActionTypes';

const initialState = {
  projectsVisible: false
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ActionTypes.MAIN_MENU_SHOW_PROJECTS:
      return {...state, projectsVisible: true};

    case ActionTypes.MAIN_MENU_HIDE_PROJECTS:
      return {...state, projectsVisible: false};

    default:
      return state;
  }
}
