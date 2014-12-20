<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ApiBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Media\Uploader\MediaUploader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StatusHandlerSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Form\Handler
 */
class StatusHandlerSpec extends ObjectBehavior
{
    function let(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        MediaFactory $mediaFactory,
        MediaUploader $uploader
    )
    {
        $this->beConstructedWith($formFactory, $manager, $eventDispatcher, $mediaFactory, $uploader);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Form\Handler\StatusHandler');
    }

    function it_extends_core_abstract_handler()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\FormHandler\AbstractFormHandler');
    }

    function it_handles_form(Request $request, StatusInterface $status, FormFactory $formFactory, FormInterface $form)
    {
        $formFactory->create(Argument::type('\Kreta\Bundle\ApiBundle\Form\Type\StatusType'), $status, [])
            ->shouldBeCalled()->willReturn($form);

        $this->handleForm($request, $status, [])->shouldReturn($form);
    }
}
