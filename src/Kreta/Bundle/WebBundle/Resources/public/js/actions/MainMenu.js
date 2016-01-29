import ActionTypes              from '../constants/ActionTypes';
import { routeActions }       from 'react-router-redux';

const Actions = {
  showProjects: () => {
    return {
      type: ActionTypes.MAIN_MENU_SHOW_PROJECTS
    }
  },
  hideProjects: () => {
    return {
      type: ActionTypes.MAIN_MENU_HIDE_PROJECTS
    };
  },
  highlightProject: (project) => {
    return {
      type: ActionTypes.MAIN_MENU_HIGHLIGHT_PROJECT,
      highlightedProject: project
    }
  }
};

export default Actions;
