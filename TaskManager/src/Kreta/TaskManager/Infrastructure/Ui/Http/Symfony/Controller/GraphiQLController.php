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

namespace Kreta\TaskManager\Infrastructure\Ui\Http\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GraphiQLController extends Controller
{
    public function indexAction(Request $request, $schemaName = null)
    {
        if (null === $schemaName) {
            $endpoint = $this->generateUrl('overblog_graphql_endpoint', [
                'access_token' => $request->query->get('access_token'),
            ]);
        } else {
            $endpoint = $this->generateUrl('overblog_graphql_multiple_endpoint', [
                'schemaName'   => $schemaName,
                'access_token' => $request->query->get('access_token'),
            ]);
        }

        return $this->render(
            $this->getParameter('overblog_graphql.graphiql_template'),
            [
                'endpoint' => $endpoint,
                'versions' => [
                    'graphiql' => $this->getParameter('overblog_graphql.versions.graphiql'),
                    'react'    => $this->getParameter('overblog_graphql.versions.react'),
                ],
            ]
        );
    }
}
