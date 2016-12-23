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
    createProject(input: $input) {
      project {
        id,
        name,
        slug,
        organization {
          id,
          name,
          slug
        }
      }
    }
  }
`;

class CreateProjectMutation extends RelayQuery.Mutation {
  constructor(projectName, projectShortName, organization) {
    super(mutation, {}, {
      input: {
        clientMutationId: Math.random().toString(36),
        name: projectName,
        slug: projectShortName,
        organizationId: organization
      }
    });

  }
}

class CreateProjectMutationRequest extends RelayMutationRequest {
  static build(projectInputData) {
    return new RelayMutationRequest(
      new CreateProjectMutation(
        projectInputData.name,
        projectInputData.shortName,
        projectInputData.organization,
      )
    );
  }
}

export default CreateProjectMutationRequest;
