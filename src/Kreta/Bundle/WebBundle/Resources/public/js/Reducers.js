import { combineReducers }         from 'redux';
import { routeReducer as routing } from 'react-router-redux';
import projects                    from './reducers/Projects';
import profile                     from './reducers/Profile';
import mainMenu                    from './reducers/MainMenu';

export default combineReducers({
  routing,
  projects,
  profile,
  mainMenu
});
