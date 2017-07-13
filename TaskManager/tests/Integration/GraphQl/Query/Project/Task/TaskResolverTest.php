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

class TaskResolverTest extends JsonApiTestCase
{
    public function testNonExistTaskByIdResolver()
    {
        $this->taskResolver('access-token-1', 'non-exist-task-id', '/nonexistent_task_by_id');
    }

    public function testTaskByIdResolver()
    {
        $this->taskResolver('access-token-1', '42eb4472-1225-11e7-93ae-92361f002671', '/task');
    }

    public function testTaskWithOtherUserResolver()
    {
        $this->taskResolver(
            'access-token-2',
            '42eb4472-1225-11e7-93ae-92361f002671',
            '/task_with_other_user'
        );
    }

    private function taskResolver(string $token, string $id, string $jsonResult) : void
    {
        $this->client->request('POST', '/?access_token=' . $token, [
            'query'       => <<<EOF
query TaskQueryRequest(\$id: ID!) {
  task(id: \$id) {
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
  }
}
EOF
            , 'variables' => ['id' => $id],
        ]);
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'graphql/query/project/task' . $jsonResult);
    }
}
