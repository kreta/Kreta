<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ApiBundle\Controller;

use Kreta\Bundle\ApiBundle\spec\Kreta\Bundle\ApiBundle\Controller\BaseRestController;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RestControllerSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Controller
 */
class RestControllerSpec extends BaseRestController
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Controller\RestController');
    }

    function it_extends_fos_rest_controller()
    {
        $this->shouldHaveType('FOS\RestBundle\Controller\FOSRestController');
    }
}
