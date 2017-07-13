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

namespace Kreta\TaskManager\Tests\Integration\GraphQl\Query\Project;

use Lakion\ApiTestCase\JsonApiTestCase;

class ProjectsResolverTest extends JsonApiTestCase
{
    public function testProjectsResolver()
    {
        $this->projectsResolver('access-token-1', [], '/projects');
    }

    public function testProjectsFilteredByNameResolver()
    {
        $this->projectsResolver('access-token-1', ['name' => '2'], '/projects_filtered_by_name');
    }

    public function testProjectsFilteredByOrganizationResolver()
    {
        $this->projectsResolver(
            'access-token-1',
            [
                'organizationId' => '71298d2c-0ff4-11e7-93ae-92361f002671',
            ],
            '/projects_filtered_by_organization'
        );
    }

    public function testProjectsWithAfter3AndFirst2()
    {
        $this->projectsResolver('access-token-1', ['after' => '3', 'first' => '2'], '/projects_paginated');
    }

    public function testProjectsWithOtherUserResolver()
    {
        $this->projectsResolver('access-token-2', [], '/projects_of_user2');
    }

    private function projectsResolver($token, $projectConnectionInput, $jsonResult)
    {
        $this->client->request('POST', '/?access_token=' . $token, [
            'query'       => <<<EOF
query ProjectsQueryRequest(\$projectConnectionInput: ProjectConnectionInput!) {
  projects(projectConnectionInput: \$projectConnectionInput) {
    totalCount,
    edges {
      node {
        id,
        name,
        slug,
        organization {
          id,
          name,
          slug,
          owners {
            id
          },
          organization_members {
            id
          }
        }
      }
    }
  }
}
EOF
            , 'variables' => ['projectConnectionInput' => $projectConnectionInput],
        ]);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'graphql/query/project' . $jsonResult);
    }
}
