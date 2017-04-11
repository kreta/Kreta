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

class OrganizationsResolverTest extends JsonApiTestCase
{
    public function testOrganizationsResolver()
    {
        $this->organizationsResolver(
            'access-token-1',
            [
                'name' => '',
            ],
            '/organizations'
        );
    }

    public function testOrganizationsFilteredByNameResolver()
    {
        $this->organizationsResolver(
            'access-token-1',
            [
                'name' => '2',
            ],
            '/organizations_filtered'
        );
    }

    public function testOrganizationsWithAfter3AndFirst2()
    {
        $this->organizationsResolver(
            'access-token-1',
            [
                'after' => '3',
                'first' => '2',
            ],
            '/organizations_paginated'
        );
    }

    public function testOrganizationsWithOtherUserResolver()
    {
        $this->organizationsResolver(
            'access-token-2',
            [
                'name' => '',
            ],
            '/organizations_of_user2'
        );
    }

    private function organizationsResolver($token, $organizationConnectionInput, $jsonResult)
    {
        $this->client->request('POST', '/?access_token=' . $token, [
            'query'       => <<<EOF
query OrganizationsQueryRequest(\$organizationConnectionInput: OrganizationConnectionInput!) {
  organizations(organizationConnectionInput: \$organizationConnectionInput) {
    totalCount,
    edges {
      node {
        id,
        name,
        slug,
        owners {
          id
        }
        projects(first: -1) {
          totalCount,
          pageInfo {
            hasNextPage
          },
          edges {
            node {
              id,
              name,
              slug,
              organization {
                slug
              }
            }
          }
        }
      }
    }
  }
}
EOF
            , 'variables' => ['organizationConnectionInput' => $organizationConnectionInput],
        ]);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'graphql/query/organization' . $jsonResult);
    }
}
