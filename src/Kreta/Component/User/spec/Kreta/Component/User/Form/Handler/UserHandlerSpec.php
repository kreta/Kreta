<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\User\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Media\Uploader\MediaUploader;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserHandlerSpec.
 *
 * @package spec\Kreta\Component\User\Form\Handler
 */
class UserHandlerSpec extends ObjectBehavior
{
    function let(
        FormFactoryInterface $formFactory,
        ObjectManager $manager,
        MediaFactory $mediaFactory,
        MediaUploader $uploader
    )
    {
        $this->beConstructedWith($formFactory, $manager, 'kreta_user_user_type', $mediaFactory, $uploader);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\User\Form\Handler\UserHandler');
    }

    function it_extends_kreta_form_handler()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Handler\Handler');
    }

    function it_handles_form_that_tests_handle_user_photo(
        Request $request,
        UserInterface $user,
        FormFactory $formFactory,
        FormBuilderInterface $formBuilder,
        FormInterface $form,
        FileBag $fileBag,
        MediaFactory $mediaFactory,
        MediaInterface $media,
        ObjectManager $manager,
        MediaUploader $uploader
    )
    {
        $image = new UploadedFile('', '', null, null, 99, true); //Avoids file not found exception
        $formFactory->createNamedBuilder('', 'kreta_user_user_type', $user, [])
            ->shouldBeCalled()->willReturn($formBuilder);
        $formBuilder->getForm()->shouldBeCalled()->willReturn($form);
        $request->isMethod('POST')->shouldBeCalled()->willReturn(true);
        $form->handleRequest($request)->shouldBeCalled();
        $form->isValid()->shouldBeCalled()->willReturn(true);

        $fileBag->get('photo')->shouldBeCalled()->willReturn($image);
        $request->files = $fileBag;

        $mediaFactory->create($image)->shouldBeCalled()->willReturn($media);
        $uploader->upload($media)->shouldBeCalled();
        $user->setPhoto($media)->shouldBeCalled()->willReturn($user);

        $manager->persist($user)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->handleForm($request, $user, []);
    }
}
