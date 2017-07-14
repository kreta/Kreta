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

class ProjectResolverTest extends JsonApiTestCase
{
    public function testNonExistProjectByIdResolver() : void
    {
        $this->projectByIdResolver('access-token-1', 'non-exist-project-id', '/nonexistent_project_by_id');
    }

    public function testProjectByIdResolver() : void
    {
        $this->projectByIdResolver('access-token-1', '0dadad5e-1220-11e7-93ae-92361f002671', '/project');
    }

    public function testNonExistProjectBySlugResolver() : void
    {
        $this->projectByInputResolver('access-token-1', [
            'slug'             => 'non-exist-project-slug',
            'organizationSlug' => 'organization-0',
        ], '/nonexistent_project_by_slug');
    }

    public function testProjectBySlugResolver() : void
    {
        $this->projectByInputResolver('access-token-1', [
            'slug'             => 'project-1',
            'organizationSlug' => 'organization-0',
        ], '/project_by_slug');
    }

    public function testProjectWithOtherUserResolver() : void
    {
        $this->projectByIdResolver(
            'access-token-2',
            '0dadad5e-1220-11e7-93ae-92361f002671',
            '/project_with_other_user'
        );
    }

    private function projectByIdResolver(string $token, string $id, string $jsonResult) : void
    {
        $this->projectResolver($token, $jsonResult, [
            'query'       => <<<EOF
query ProjectQueryRequest(\$id: ID!, \$first: Int) {
  project(id: \$id) {
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
    },
    tasks(first: \$first) {
      totalCount
      edges {
        node {
          id,
          title,
          description,
          numeric_id,
          progress,
          priority,
          assignee {
            id
          },
          creator {
            id
          }
        }
      },
      pageInfo {
        endCursor,
        hasNextPage
      }
    }
  }
}
EOF
            , 'variables' => ['id' => $id, 'first' => 10],
        ]);
    }

    private function projectByInputResolver(string $token, array $projectInput, string $jsonResult) : void
    {
        $this->projectResolver($token, $jsonResult, [
            'query'       => <<<EOF
query ProjectQueryRequest(\$projectInput: ProjectInput!) {
  project(projectInput: \$projectInput) {
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
EOF
            , 'variables' => ['projectInput' => $projectInput],
        ]);
    }

    private function projectResolver(string $token, string $jsonResult, array $query) : void
    {
        $this->client->request('POST', '/?access_token=' . $token, $query);
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'graphql/query/project' . $jsonResult);
    }
}
