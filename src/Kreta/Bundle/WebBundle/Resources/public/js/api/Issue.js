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

class IssueApi extends Api {
  getIssues(query = null) {
    return this.get('/issues', query);
  }

  getIssue(issueId, query = null) {
    return this.get(`/issues/${issueId}`, query);
  }
}

const instance = new IssueApi();

export default instance;
