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

namespace Kreta\TaskManager\Tests\Integration\GraphQl\Query\Projects;

use Lakion\ApiTestCase\JsonApiTestCase;

class ProjectsResolverTest extends JsonApiTestCase
{
//    public function testProjectsResolver()
//    {
//        $this->projectsResolver(
//            'access-token-1',
//            [
//                'name' => '',
//            ],
//            '/projects'
//        );
//    }
//
    public function testProjectsFilteredByNameResolver()
    {
        $this->projectsResolver(
            'access-token-1',
            [
                'name' => '2',
            ],
            '/projects_filtered'
        );
    }

//    public function testProjectsWithAfter3AndFirst2()
//    {
//        $this->projectsResolver(
//            'access-token-1',
//            [
//                'after' => '3',
//                'first' => '2',
//            ],
//            '/projects_paginated'
//        );
//    }
//
//    public function testProjectsWithOtherUserResolver()
//    {
//        $this->projectsResolver(
//            'access-token-2',
//            [
//                'name' => '',
//            ],
//            '/projects_of_user2'
//        );
//    }
//
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
