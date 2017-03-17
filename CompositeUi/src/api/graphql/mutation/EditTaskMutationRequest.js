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
    editTask(input: $input) {
      task {
        id,
        title,
        description,
        numeric_id,
        progress,
        priority,
        assignee,
        creator,
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

class EditTaskMutation extends RelayQuery.Mutation {
  // eslint-disable-next-line max-params
  constructor(taskId, taskTitle, taskDescription, assignee, taskPriority, parent = null) {
    super(mutation, {}, {
      input: {
        clientMutationId: Math.random().toString(36),
        id: taskId,
        title: taskTitle,
        description: taskDescription,
        assigneeId: assignee,
        priority: taskPriority.toUpperCase(),
        parentId: parent
      }
    });
  }
}

class EditTaskMutationRequest extends RelayMutationRequest {
  static build(taskInputData) {
    return new RelayMutationRequest(
      new EditTaskMutation(
        taskInputData.id,
        taskInputData.title,
        taskInputData.description,
        taskInputData.assignee,
        taskInputData.priority,
        taskInputData.parent,
      )
    );
  }
}

export default EditTaskMutationRequest;
