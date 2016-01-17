/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import ActionTypes from '../constants/ActionTypes'
import AppDispatcher from '../dispatcher/AppDispatcher';
import * as ApiIssueUtils from '../util/ApiIssueUtils';

export function issueCreate(issue) {
  AppDispatcher.dispatch({
    type: ActionTypes.ISSUE_CREATE,
    issue: issue
  });

  ApiIssueUtils.createIssue(issue);
}

export function issueCreated(issue) {
  AppDispatcher.dispatch({
    type: ActionTypes.ISSUE_CREATED,
    issue: issue
  });
}
