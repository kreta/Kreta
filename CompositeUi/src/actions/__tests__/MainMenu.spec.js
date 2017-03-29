/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import mockStore from '../../__mocks__/mockStore';
import ActionTypes from '../../constants/ActionTypes';
import MainMenu from '../../actions/MainMenu';

describe('Main menu actions', () => {
  it('shows projects', () => {
    const expectedActions = [
      {type: ActionTypes.MAIN_MENU_SHOW_PROJECTS},
    ];

    const store = mockStore({projectVisible: false});

    store.dispatch(MainMenu.showProjects());
    expect(store.getActions()).toEqual(expectedActions);
  });
});
