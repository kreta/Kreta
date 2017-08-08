/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

export default {
  build: organizationInputData =>
    new Promise((resolve, reject) => {
      if (typeof organizationInputData.name === 'undefined') {
        reject({source: {errors: []}});
      } else {
        resolve({
          response: {
            createOrganization: {
              organization: {
                id: 'organization-id',
                name: 'New organization',
                slug: 'new-organization',
              },
            },
          },
        });
      }
    }),
};
