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
    removeMemberToOrganization(input: $input) {
      organization {
        id,
        name,
        slug
      }
    }
  }
`;

class RemoveMemberToOrganizationMutation extends RelayQuery.Mutation {
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

class RemoveMemberToOrganizationMutationRequest extends RelayMutationRequest {
  static build(inputData) {
    return new RelayMutationRequest(
      new RemoveMemberToOrganizationMutation(
        inputData.userId,
        inputData.organizationId,
      ),
    );
  }
}

export default RemoveMemberToOrganizationMutationRequest;
