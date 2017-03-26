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
        $id = '12cf8031-ecbb-4569-a3aa-c5143ccf146d';

        $this->client->request('POST', '/', [
            'query'       => <<<EOF
"query OrganizationQueryRequest(id: ID!) {
  organization(id: id) {
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
}"
EOF
            , 'variables' => ['id' => $id],
        ]);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'graphql/organization_resolver');
    }
}
