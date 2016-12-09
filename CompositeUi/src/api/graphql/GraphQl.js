/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import DefaultNetworkLayer from 'react-relay/lib/RelayDefaultNetworkLayer';

import Config from '../../Config';

class GraphQl {
  constructor(uri = '/') {
    this.relayNetworkLayer = new DefaultNetworkLayer(`${Config.baseUrl}${uri}?access_token=${this.accessToken()}`);
  }

  baseUrl() {
    return Config.taskManagerUrl;
  }

  accessToken() {
    return localStorage.token;
  }

  networkLayer() {
    return this.relayNetworkLayer;
  }
}

const GraphQlInstance = new GraphQl();

export default GraphQlInstance;
