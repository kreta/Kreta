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

namespace Kreta\TaskManager\Tests\Integration\GraphQl\Query\Task\Task;

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

//    public function testTasksFilteredByProjectResolver() : void
//    {
//        $this->tasksResolver('access-token-2', ['projectId' => 'Task 1'], '/tasks_filtered_by_project');
//    }

    public function testTasksFilteredByPriorityResolver() : void
    {
        $this->tasksResolver('access-token-2', ['priority' => 'MEDIUM'], '/tasks_filtered_by_priority');
    }

    public function testTasksFilteredByProgressResolver() : void
    {
        $this->tasksResolver('access-token-2', ['progress' => 'TODO'], '/tasks_filtered_by_progress');
    }

//    public function testTasksFilteredByAssigneeResolver() : void
//    {
//        $this->tasksResolver('access-token-2', ['assigneeId' => ''], '/tasks_filtered_by_assignee');
//    }
//
//    public function testTasksFilteredByCreatorResolver() : void
//    {
//        $this->tasksResolver('access-token-2', ['creatorId' => ''], '/tasks_filtered_by_creator');
//    }

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
        creator {
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
