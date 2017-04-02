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
    public function testNonExistOrganizationByIdResolver()
    {
        $this->organizationById(
            'access-token-1',
            'non-exist-organization-id',
            '/nonexistent_organization_by_id'
        );
    }

    public function testNonExistOrganizationBySlugResolver()
    {
        $this->organizationBySlug(
            'access-token-1',
            'non-exist-organization-slug',
            '/nonexistent_organization_by_slug'
        );
    }

    public function testUnauthorizedOrganizationByIdResolver()
    {
        $this->organizationById(
            'access-token-2',
            '71298d2c-0ff4-11e7-93ae-92361f002671',
            '/unauthorized_organization_by_id'
        );
    }

    public function testUnauthorizedOrganizationBySlugResolver()
    {
        $this->organizationBySlug(
            'access-token-2',
            'organization-0',
            '/unauthorized_organization_by_slug'
        );
    }

    public function testOrganizationByIdResolver()
    {
        $this->organizationById(
            'access-token-1',
            '71298d2c-0ff4-11e7-93ae-92361f002671',
            '/organization'
        );
    }

    public function testOrganizationBySlugResolver()
    {
        $this->organizationBySlug('access-token-1', 'organization-0', '/organization');
    }

    private function organizationById($token, $id, $jsonResult)
    {
        return $this->organizationResolver($token, $id, 'id', 'ID!', $jsonResult);
    }

    private function organizationBySlug($token, $slug, $jsonResult)
    {
        return $this->organizationResolver($token, $slug, 'slug', 'String!', $jsonResult);
    }

    private function organizationResolver($token, $value, $name, $type, $jsonResult)
    {
        $this->client->request('POST', '/?access_token=' . $token, [
            'query'       => <<<EOF
query OrganizationQueryRequest(\$$name: $type) {
  organization($name: \$$name) {
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
            , 'variables' => [$name => $value],
        ]);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'graphql/query/organization' . $jsonResult);
    }
}
