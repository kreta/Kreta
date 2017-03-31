<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kreta\TaskManager\Tests\Integration\GraphQl\Query;

use Lakion\ApiTestCase\JsonApiTestCase;

class OrganizationResolverTest extends JsonApiTestCase
{
    public function testValidOrganizationResolver()
    {
        $this->organizationResolver('71298d2c-0ff4-11e7-93ae-92361f002671', 'graphql/organization_resolver');
    }

    private function organizationResolver($id, $jsonResult)
    {
        $this->client->request('POST', '/', [
            'query'       => <<<EOF
query OrganizationQueryRequest(\$id: ID!) {
  organization(id: \$id) {
    id,
    name,
    slug,
    organization_members {
      id
    },
    owners {
      id
    },
    _projects4l96UD:projects(first:-1) {
      edges {
        node {
          id,
          name,
          slug
        },
        cursor
      },
      pageInfo {
        hasNextPage,
        hasPreviousPage
      }
    }
  }
}
EOF
            , 'variables' => ['id' => $id],
        ]);

        $response = $this->client->getResponse();

        $this->assertResponse($response, $jsonResult);
    }
}
