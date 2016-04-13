/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {combineReducers} from 'redux';
import {routeReducer as routing} from 'react-router-redux';

import currentProject from './reducers/CurrentProject';
import mainMenu from './reducers/MainMenu';
import notification from './reducers/Notification';
import profile from './reducers/Profile';
import projects from './reducers/Projects';
import organizations from './reducers/Organizations';
import currentOrganization from './reducers/CurrentOrganization';

export default combineReducers({
  currentProject,
  mainMenu,
  notification,
  profile,
  projects,
  routing,
  organizations,
  currentOrganization
});
