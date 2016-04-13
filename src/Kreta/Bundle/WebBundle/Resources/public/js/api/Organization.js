/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Api from './Api';

class OrganizationApi extends Api {
  getOrganizations(query = null) {
    return this.get('/organizations', query);
  }

  getOrganization(organizationId, query = null) {
    return this.get(`/organizations/${organizationId}`, query);
  }

  postOrganization(payload) {
    return this.post('/organizations', payload);
  }

  putOrganization(organizationId, payload) {
    return this.put(`/organizations/${organizationId}`, payload);
  }
}

const instance = new OrganizationApi();

export default instance;
