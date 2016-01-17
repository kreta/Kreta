/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {issueCreated} from '../actions/IssueActionCreator';

export function createIssue(issue) {
  setTimeout(() => {
    issueCreated(issue);
  }, 100)
}
