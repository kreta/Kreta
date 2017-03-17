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
    editProject(input: $input) {
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

class EditProjectMutation extends RelayQuery.Mutation {
  constructor(projectId, projectName, projectShortName) {
    super(mutation, {}, {
      input: {
        clientMutationId: Math.random().toString(36),
        id: projectId,
        name: projectName,
        slug: projectShortName
      }
    });

  }
}

class EditProjectMutationRequest extends RelayMutationRequest {
  static build(projectInputData) {
    return new RelayMutationRequest(
      new EditProjectMutation(
        projectInputData.id,
        projectInputData.name,
        projectInputData.short_name
      )
    );
  }
}

export default EditProjectMutationRequest;
