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
    createTask(input: $input) {
      task {
        id,
        title,
        numeric_id,
        description,
        assignee,
        priority,
        project {
          id,
          slug,
          organization {
            id,
            slug
          }
        },
        parent_task {
          id,
          title
        }
      }
    }
  }
`;

class CreateTaskMutation extends RelayQuery.Mutation {
  // eslint-disable-next-line max-params
  constructor(taskTitle, taskDescription, assignee, taskPriority, project, parent = null) {
    super(mutation, {}, {
      input: {
        clientMutationId: Math.random().toString(36),
        title: taskTitle,
        description: taskDescription,
        assigneeId: assignee,
        priority: taskPriority.toUpperCase(),
        projectId: project,
        parentId: parent
      }
    });

  }
}

class CreateTaskMutationRequest extends RelayMutationRequest {
  static build(taskInputData) {
    return new RelayMutationRequest(
      new CreateTaskMutation(
        taskInputData.title,
        taskInputData.description,
        taskInputData.assignee,
        taskInputData.priority,
        taskInputData.project,
        taskInputData.parent,
      )
    );
  }
}

export default CreateTaskMutationRequest;
