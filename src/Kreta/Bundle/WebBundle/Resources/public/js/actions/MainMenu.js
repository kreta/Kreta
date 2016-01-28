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
  }
};

export default Actions;
