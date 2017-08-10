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
    addMemberToOrganization(input: $input) {
      organization {
        id,
        name,
        slug
      }
    }
  }
`;

class AddMemberToOrganizationMutation extends RelayQuery.Mutation {
  constructor(userId, organizationId) {
    super(
      mutation,
      {},
      {
        input: {
          clientMutationId: Math.random().toString(36),
          userId,
          organizationId,
        },
      },
    );
  }
}

class AddMemberToOrganizationMutationRequest extends RelayMutationRequest {
  static build(inputData) {
    return new RelayMutationRequest(
      new AddMemberToOrganizationMutation(
        inputData.userId,
        inputData.organizationId,
      ),
    );
  }
}

export default AddMemberToOrganizationMutationRequest;
