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

const
  query = RelayQuery.Root.create(
    Relay.QL`
      query {
        tasks {
          totalCount
          edges {
            node {
              id
              title
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
            endCursor
            hasNextPage
          }
        }
      }`
  ),
  TasksQueryRequest = new RelayQueryRequest(query);

export default TasksQueryRequest;
