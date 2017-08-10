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
    createOrganization(input: $input) {
      organization {
        id,
        name,
        slug
      }
    }
  }
`;

class CreateOrganizationMutation extends RelayQuery.Mutation {
  constructor(organizationName) {
    super(
      mutation,
      {},
      {
        input: {
          clientMutationId: Math.random().toString(36),
          name: organizationName,
        },
      },
    );
  }
}

class CreateOrganizationMutationRequest extends RelayMutationRequest {
  static build(organizationInputData) {
    return new RelayMutationRequest(
      new CreateOrganizationMutation(organizationInputData.name),
    );
  }
}

export default CreateOrganizationMutationRequest;
