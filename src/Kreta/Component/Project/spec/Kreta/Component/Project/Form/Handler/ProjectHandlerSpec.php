<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Project\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Media\Uploader\MediaUploader;
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
 * Class ProjectHandlerSpec.
 *
 * @package spec\Kreta\Component\Project\Form\Handler
 */
class ProjectHandlerSpec extends ObjectBehavior
{
    function let(
        FormFactoryInterface $formFactory,
        ObjectManager $manager,
        MediaFactory $mediaFactory,
        MediaUploader $uploader
    )
    {
        $this->beConstructedWith($formFactory, $manager, 'kreta_project_project_type', $mediaFactory, $uploader);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Form\Handler\ProjectHandler');
    }

    function it_extends_kreta_form_handler()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Handler\Handler');
    }

    function it_handles_form_that_tests_handle_project_image(
        Request $request,
        ProjectInterface $project,
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
        $formFactory->createNamedBuilder('', 'kreta_project_project_type', $project, [])
            ->shouldBeCalled()->willReturn($formBuilder);
        $formBuilder->getForm()->shouldBeCalled()->willReturn($form);
        $request->isMethod('POST')->shouldBeCalled()->willReturn(true);
        $form->handleRequest($request)->shouldBeCalled();
        $form->isValid()->shouldBeCalled()->willReturn(true);

        $fileBag->get('image')->shouldBeCalled()->willReturn($image);
        $request->files = $fileBag;

        $mediaFactory->create($image)->shouldBeCalled()->willReturn($media);
        $uploader->upload($media)->shouldBeCalled();
        $project->setImage($media)->shouldBeCalled()->willReturn($project);

        $manager->persist($project)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->handleForm($request, $project, []);
    }
}
