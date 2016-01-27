/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../scss/app';

import React                    from 'react';
import ReactDOM                 from 'react-dom';
import createBrowserHistory     from 'history/lib/createBrowserHistory';
import configureStore           from './stores/Store';
import Root                     from './views/layout/Root';

const history = createBrowserHistory();
const store  = configureStore(history);

const node = <Root routerHistory={history} store={store}/>;

ReactDOM.render(node, document.getElementById('application'));

