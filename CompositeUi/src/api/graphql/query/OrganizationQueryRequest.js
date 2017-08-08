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
    organization(slug: $slug) {
      id,
      name,
      slug,
      organization_members {
        id,
      },
      owners {
        id,
      },
      projects(first: 25) {
        edges {
          node {
            id,
            name,
            slug,
          }
        }
      }
    }
  }
`;

class OrganizationQueryRequest extends RelayQueryRequest {
  static build(slug) {
    return new RelayQueryRequest(
      RelayQuery.Root.create(
        query,
        {},
        {
          slug,
        },
      ),
    );
  }
}

export default OrganizationQueryRequest;
