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
    projects(projectConnectionInput: $projectConnectionInput) {
      totalCount
      edges {
        node {
          id,
          name,
          slug,
          organization {
            id,
            name,
            slug
          }
        }
        cursor
      }
      pageInfo {
        endCursor
        hasNextPage
      }
    }
  }
`;

class ProjectsQueryRequest extends RelayQueryRequest {
  static build({name, endCursor = null} = {}) {
    const projectConnectionInput = {first: 50};

    if (name) {
      projectConnectionInput.name = name;
    }
    if (endCursor) {
      projectConnectionInput.after = endCursor;
    }

    return new RelayQueryRequest(
      RelayQuery.Root.create(
        query,
        {},
        {
          projectConnectionInput,
        },
      ),
    );
  }
}

export default ProjectsQueryRequest;
