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

namespace Kreta\TaskManager\Tests\Integration\GraphQl\Query\Organization;

use Lakion\ApiTestCase\JsonApiTestCase;

class OwnerResolverTest extends JsonApiTestCase
{
    public function testNonExistOrganizationResolver()
    {
        $this->ownerResolver(
            'access-token-1',
            'non-exist-organization-id',
            'a38f8ef4-400b-4229-a5ff-712ff5f72b27',
            '/nonexistent_organization_by_owner_id'
        );
    }

    public function testUnauthorizedOrganizationResolver()
    {
        $this->ownerResolver(
            'access-token-2',
            '71298d2c-0ff4-11e7-93ae-92361f002671',
            'a38f8ef4-400b-4229-a5ff-712ff5f72b27',
            '/unauthorized_organization_by_owner_id'
        );
    }

    public function testNonExistOwnerResolver()
    {
        $this->ownerResolver(
            'access-token-1',
            '71298d2c-0ff4-11e7-93ae-92361f002671',
            'non-exist-owner-id',
            '/nonexistent_owner_by_id'
        );
    }

    public function testOwnerResolver()
    {
        $this->ownerResolver(
            'access-token-1',
            '71298d2c-0ff4-11e7-93ae-92361f002671',
            'a38f8ef4-400b-4229-a5ff-712ff5f72b27',
            '/owner'
        );
    }

    private function ownerResolver($token, $organizationId, $value, $jsonResult)
    {
        $this->client->request('POST', '/?access_token=' . $token, [
            'query'       => <<<EOF
query MemberQueryRequest(\$organizationId: ID!, \$ownerId: ID!) {
  owner(organizationId: \$organizationId, ownerId: \$ownerId) {
    id,
    organization {
      id,
      name
    }
  }
}
EOF
            , 'variables' => [
                'organizationId' => $organizationId,
                'ownerId'        => $value,
            ],
        ]);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'graphql/query/organization' . $jsonResult);
    }
}
