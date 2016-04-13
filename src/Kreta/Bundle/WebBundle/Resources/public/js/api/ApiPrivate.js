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
import Config from './../Config';

class OrganizationApiPrivate extends Api {
  baseUrl() {
    return `${Config.baseUrl}/private`;
  }

  getOrganization(organizationSlug, query = null) {
    return this.get(`/organizations/${organizationSlug}`, query);
  }
}

class ProjectApiPrivate extends Api {
  baseUrl() {
    return `${Config.baseUrl}/private`;
  }

  getProjectsByOrganization(organizationSlug, query = null) {
    return this.get(`/organizations/${organizationSlug}/projects`, query);
  }

  getProjectByOrganization(organizationSlug, projectSlug, query = null) {
    return this.get(`/organizations/${organizationSlug}/projects/${projectSlug}`, query);
  }
}

export const organizationApiPrivateInstance = new OrganizationApiPrivate(),
  projectApiPrivateInstance = new ProjectApiPrivate();
