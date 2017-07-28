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

namespace Kreta\TaskManager\Tests\Integration\GraphQl\Query\Project\Task;

use Lakion\ApiTestCase\JsonApiTestCase;

class TasksResolverTest extends JsonApiTestCase
{
    public function testTasksResolver() : void
    {
        $this->tasksResolver('access-token-2', [], '/tasks');
    }

    public function testTasksFilteredByTitleResolver() : void
    {
        $this->tasksResolver('access-token-2', ['title' => 'Task 1'], '/tasks_filtered_by_title');
    }

    public function testTasksFilteredByParentResolver() : void
    {
        $this->tasksResolver('access-token-2', [
            'parentId' => '42eb534a-1225-11e7-93ae-92361f002671',
        ], '/tasks_filtered_by_parent');
    }

    public function testTasksFilteredByProjectResolver() : void
    {
        $this->tasksResolver('access-token-2', [
            'projectId' => '0dadb844-1220-11e7-93ae-92361f002671',
        ], '/tasks_filtered_by_project');
    }

    public function testTasksFilteredByPriorityResolver() : void
    {
        $this->tasksResolver('access-token-2', ['priority' => 'MEDIUM'], '/tasks_filtered_by_priority');
    }

    public function testTasksFilteredByProgressResolver() : void
    {
        $this->tasksResolver('access-token-2', ['progress' => 'DOING'], '/tasks_filtered_by_progress');
    }

    public function testTasksFilteredByAssigneeResolver() : void
    {
        $this->tasksResolver('access-token-2', [
            'assigneeId' => '6704c278-e106-449f-a73d-2508e96f6177',
        ], '/tasks_filtered_by_assignee');
    }

    public function testTasksFilteredByReporterResolver() : void
    {
        $this->tasksResolver('access-token-2', [
            'reporterId' => '6704c278-e106-449f-a73d-2508e96f6177',
        ], '/tasks_filtered_by_reporter');
    }

    public function testTasksFilteredByMultipleResolver() : void
    {
        $this->tasksResolver('access-token-2', [
            'reporterId' => '6704c278-e106-449f-a73d-2508e96f6177',
            'priority'  => 'MEDIUM',
            'progress'  => 'DOING',
        ], '/tasks_filtered_by_multiple');
    }

    public function testTasksWithAfter3AndFirst2() : void
    {
        $this->tasksResolver('access-token-2', ['after' => '3', 'first' => '2'], '/tasks_paginated');
    }

    public function testTasksWithOtherUserResolver() : void
    {
        $this->tasksResolver('access-token-1', [], '/tasks_of_user2');
    }

    private function tasksResolver(string $token, array $taskConnectionInput, string $jsonResult) : void
    {
        $this->client->request('POST', '/?access_token=' . $token, [
            'query'       => <<<EOF
query TasksQueryRequest(\$taskConnectionInput: TaskConnectionInput!) {
  tasks(taskConnectionInput: \$taskConnectionInput) {
    totalCount,
    edges {
      node {
        id
        title,
        description,
        numeric_id,
        priority,
        progress,
        assignee {
          id
        },
        reporter {
          id
        },
        project {
          id,
          name,
          slug
        },
      }
      cursor
    },
    pageInfo {
      endCursor,
      hasNextPage
    }
  }
}
EOF
            , 'variables' => ['taskConnectionInput' => $taskConnectionInput],
        ]);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'graphql/query/project/task' . $jsonResult);
    }
}
