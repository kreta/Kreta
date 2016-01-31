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

class ProjectApi extends Api {
  getProjects(query = null) {
    return this.get('/projects', query);
  }

  getProject(projectId, query = null) {
    return this.get(`/projects/${projectId}`, query);
  }

  postProject(payload) {
    return this.post('/projects', payload);
  }
}

const instance = new ProjectApi();

export default instance;
