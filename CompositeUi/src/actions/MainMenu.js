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

const Actions = {
  showProjects: () => ({
    type: ActionTypes.MAIN_MENU_SHOW_PROJECTS
  }),
  hideProjects: () => ({
    type: ActionTypes.MAIN_MENU_HIDE_PROJECTS
  }),
  highlightProject: (project) => ({
    type: ActionTypes.MAIN_MENU_HIGHLIGHT_PROJECT,
    highlightedProject: project
  })
};

export default Actions;
