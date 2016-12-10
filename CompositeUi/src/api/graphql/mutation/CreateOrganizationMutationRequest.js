/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class CreateOrganizationMutationRequest {
  organizationName;

  constructor(input) {
    this.organizationName = input.name;
  }

  getQueryString() {
    return (`
      mutation CreateOrganization($input: CreateOrganizationInput!) {
        createOrganization(input: $input) {
          organization {
            id,
            name,
            slug
          }
        }
      }
    `);
  }

  getVariables() {
    return {
      input: {
        clientMutationId: this.getId(),
        name: this.organizationName
      }
    };
  }

  getFiles() {
    return null;
  }

  getId() {
    return Math.random().toString(36);
  }

  getDebugName() {
    return 'createOrganization';
  }
}

export default CreateOrganizationMutationRequest;
