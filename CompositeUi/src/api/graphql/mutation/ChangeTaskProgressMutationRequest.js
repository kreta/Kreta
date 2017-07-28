/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Relay from 'react-relay';
import RelayQuery from 'react-relay/lib/RelayQuery';
import RelayMutationRequest from 'react-relay/lib/RelayMutationRequest';

const mutation = Relay.QL`
  mutation {
    changeTaskProgress(input: $input) {
      task {
        id,
        title,
        description,
        numeric_id,
        progress,
        priority,
        assignee,
        reporter,
        project {
          id,
          slug,
          organization {
            id,
            slug
          }
        }
      }
    }
  }
`;

class ChangeTaskProgressMutation extends RelayQuery.Mutation {
  constructor(taskId, taskProgress) {
    super(mutation, {}, {
      input: {
        clientMutationId: Math.random().toString(36),
        id: taskId,
        progress: taskProgress
      }
    });
  }
}

class ChangeTaskProgressMutationRequest extends RelayMutationRequest {
  static build(taskInputData) {
    return new RelayMutationRequest(
      new ChangeTaskProgressMutation(
        taskInputData.id,
        taskInputData.progress,
      )
    );
  }
}

export default ChangeTaskProgressMutationRequest;
