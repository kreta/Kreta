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
import RelayQueryRequest from 'react-relay/lib/RelayQueryRequest';

const query = Relay.QL`
  query {
    tasks(taskConnectionInput: $taskConnectionInput) {
      totalCount,
      edges {
        node {
          id
          title,
          description,
          priority,
          progress,
          assignee {
            id
          },
          creator {
            id
          },
        }
        cursor
      }
      pageInfo {
        endCursor,
        hasNextPage
      }
    }
  }
`;

class TasksQueryRequest extends RelayQueryRequest {
  static build({projectId, priority = null, progress = null, assignee = null} = {}) {
    const taskConnectionInput = {projectId};

    if (priority) {
      taskConnectionInput.priority = priority;
    }
    if (progress) {
      taskConnectionInput.progress = progress;
    }
    if (assignee) {
      taskConnectionInput.assigneeId = assignee;
    }

    return new RelayQueryRequest(
      RelayQuery.Root.create(query, {}, {
        taskConnectionInput
      })
    );
  }
}

export default TasksQueryRequest;
