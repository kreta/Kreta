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

namespace Kreta\TaskManager\Infrastructure\Ui\Http\OverblogGraphQlBundle\Controller;

use Overblog\GraphQLBundle\Controller\GraphController as BaseGraphController;
use Symfony\Component\HttpFoundation\Request;

class GraphController extends BaseGraphController
{
    public function endpointAction(Request $request, $schemaName = null)
    {
        return parent::endpointAction($request, $schemaName);
    }

    public function batchEndpointAction(Request $request, $schemaName = null)
    {
        return parent::batchEndpointAction($request, $schemaName);
    }
}
