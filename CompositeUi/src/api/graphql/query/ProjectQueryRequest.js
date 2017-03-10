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
    project(projectInput: $projectInput) {
      id,
      name,
      slug,
      organization {
        id,
        name,
        slug
        organization_members {
          id,
        },
        owners {
          id,
        }
      },
      tasks(first: $tasksFirst) {
        edges {
          node {
            id,
            title,
            description,
            numeric_id,
            progress,
            priority,
            assignee {
              id
            },
            creator {
              id
            }
          }
        }
      }
    }
  }
`;

class ProjectQueryRequest extends RelayQueryRequest {
  static build(organizationSlug, projectSLug) {
    const projectInput = {};

    projectInput.organizationSlug = organizationSlug;
    projectInput.slug = projectSLug;

    return new RelayQueryRequest(
      RelayQuery.Root.create(query, {}, {
        projectInput,
        tasksFirst: 50
      })
    );
  }
}

export default ProjectQueryRequest;
