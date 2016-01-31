import { combineReducers } from 'redux';
import { routeReducer as routing } from 'react-router-redux';
import projects from './reducers/Projects';
import profile from './reducers/Profile';
import mainMenu from './reducers/MainMenu';
import currentProject from './reducers/CurrentProject';
import notification from './reducers/Notification';

export default combineReducers({
  routing,
  projects,
  profile,
  mainMenu,
  currentProject,
  notification
});
