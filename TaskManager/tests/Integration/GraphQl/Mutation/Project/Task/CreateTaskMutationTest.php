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

namespace Kreta\TaskManager\Tests\Integration\GraphQl\Mutation\Project\Task;

use Lakion\ApiTestCase\JsonApiTestCase;

class CreateTaskMutationTest extends JsonApiTestCase
{
    /**
     * @afterClass
     */
    public static function tearDownChangedDbData() : void
    {
        exec("sh etc/bash/install_test_env.sh");
    }

    public function testNonexistentTaskParentMutation() : void
    {
        $this->createTaskMutation(
            'access-token-1',
            [
                'clientMutationId' => '5c9fd085-cdda-49de-9272-39f304e3bd1f',
                'title'            => 'The task title',
                'description'      => 'The task description',
                'assigneeId'       => '1106e034-d6b8-46c0-a393-9f0fd92d18a1',
                'priority'         => 'HIGH',
                'projectId'        => '0dadad5e-1220-11e7-93ae-92361f002671',
                'parentId'         => 'nonexistent-parent-task-id',
            ],
            '/create_task_with_nonexistent_parent'
        );
    }

    public function testNonexistentProjectMutation() : void
    {
        $this->createTaskMutation(
            'access-token-1',
            [
                'clientMutationId' => '5c9fd085-cdda-49de-9272-39f304e3bd1f',
                'title'            => 'The task title',
                'description'      => 'The task description',
                'assigneeId'       => '1106e034-d6b8-46c0-a393-9f0fd92d18a1',
                'priority'         => 'HIGH',
                'projectId'        => 'nonexistent-project-id',
                'parentId'         => null,
            ],
            '/create_task_with_nonexistent_project'
        );
    }

    public function testNotMemberAssigneeMutation() : void
    {
        $this->createTaskMutation(
            'access-token-1',
            [
                'clientMutationId' => '5c9fd085-cdda-49de-9272-39f304e3bd1f',
                'title'            => 'The task title',
                'description'      => 'The task description',
                'assigneeId'       => '8eb29ed7-93b2-4c94-bb9b-ad4b323ad8c5',
                'priority'         => 'HIGH',
                'projectId'        => '0dadad5e-1220-11e7-93ae-92361f002671',
                'parentId'         => null,
            ],
            '/create_task_with_not_member_assignee'
        );
    }

    public function testUnauthorizedTaskCreationMutation() : void
    {
        $this->createTaskMutation(
            'access-token-2',
            [
                'clientMutationId' => '5c9fd085-cdda-49de-9272-39f304e3bd1f',
                'title'            => 'The task title',
                'description'      => 'The task description',
                'assigneeId'       => '1106e034-d6b8-46c0-a393-9f0fd92d18a1',
                'priority'         => 'HIGH',
                'projectId'        => '0dadad5e-1220-11e7-93ae-92361f002671',
                'parentId'         => null,
            ],
            '/create_task_with_not_member_creator'
        );
    }

    public function testCreateTaskMutation() : void
    {
        $this->createTaskMutation(
            'access-token-1',
            [
                'clientMutationId' => '5c9fd085-cdda-49de-9272-39f304e3bd1f',
                'title'            => 'The task title',
                'description'      => 'The task description',
                'assigneeId'       => '1106e034-d6b8-46c0-a393-9f0fd92d18a1',
                'priority'         => 'HIGH',
                'projectId'        => '0dadad5e-1220-11e7-93ae-92361f002671',
                'parentId'         => null,
            ],
            '/create_task'
        );
    }

    public function testCreateTaskWithParentMutation() : void
    {
        $this->createTaskMutation(
            'access-token-1',
            [
                'clientMutationId' => '5c9fd085-cdda-49de-9272-39f304e3bd1z',
                'title'            => 'The task title with parent',
                'description'      => 'The task description with parent',
                'assigneeId'       => '1106e034-d6b8-46c0-a393-9f0fd92d18a1',
                'priority'         => 'MEDIUM',
                'projectId'        => '0dadad5e-1220-11e7-93ae-92361f002671',
                'parentId'         => '42eb4c4c-1225-11e7-93ae-92361f002671',
            ],
            '/create_task_with_parent'
        );
    }

    private function createTaskMutation(string $token, array $input, string $jsonResult) : void
    {
        $this->client->request('POST', '/?access_token=' . $token, [
            'query'       => <<<EOF
mutation CreateTaskMutation(\$input: CreateTaskInput!) {
  createTask(input: \$input) {
    task {
      id
      title,
      description,
      numeric_id,
      progress,
      priority,
      parent_task {
        id,
        title,
        numeric_id
      },
      assignee {
        id
      },
      creator {
        id
      },
      project {
        id,
        name,
        slug,
        organization {
          id,
          slug
        }
      }
    }
  }
}
EOF
            , 'variables' => ['input' => $input],
        ]);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'graphql/mutation/project/task' . $jsonResult);
    }
}
