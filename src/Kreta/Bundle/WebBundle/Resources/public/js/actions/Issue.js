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
import IssueApi from './../api/Issue';

const Actions = {
  updateIssue: (issueData) => {
    return (dispatch) => {
      dispatch({
        type: ActionTypes.ISSUE_UPDATE
      });
      IssueApi.putIssue(issueData)
        .then((updatedIssue) => {
          dispatch({
            type: ActionTypes.ISSUE_UPDATED,
            issue: updatedIssue
          });
        })
        .catch((errorData) => {
          errorData.then((errors) => {
            dispatch({
              type: ActionTypes.ISSUE_UPDATE_ERROR,
              errors
            });
          });
        })
    };
  }
};

export default Actions;
