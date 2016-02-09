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

namespace spec\Kreta\Component\Organization\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Media\Uploader\MediaUploader;
use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
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
 * Spec file of OrganizationHandle class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationHandlerSpec extends ObjectBehavior
{
    function let(
        FormFactoryInterface $formFactory,
        ObjectManager $manager,
        MediaFactory $mediaFactory,
        MediaUploader $uploader
    ) {
        $this->beConstructedWith(
            $formFactory,
            $manager,
            'Kreta\Component\Organization\Form\Type\OrganizationType',
            $mediaFactory,
            $uploader
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Organization\Form\Handler\OrganizationHandler');
    }

    function it_extends_kreta_form_handler()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Handler\Handler');
    }

    function it_handles_form_that_tests_handle_organization_image(
        Request $request,
        OrganizationInterface $organization,
        FormFactory $formFactory,
        FormBuilderInterface $formBuilder,
        FormInterface $form,
        FileBag $fileBag,
        MediaFactory $mediaFactory,
        MediaInterface $media,
        ObjectManager $manager,
        MediaUploader $uploader
    ) {
        $image = new UploadedFile('', '', null, null, 99, true); // Avoids file not found exception
        $formFactory->createNamedBuilder(
            '',
            'Kreta\Component\Organization\Form\Type\OrganizationType',
            $organization,
            []
        )->shouldBeCalled()->willReturn($formBuilder);
        $formBuilder->getForm()->shouldBeCalled()->willReturn($form);
        $request->isMethod('POST')->shouldBeCalled()->willReturn(true);
        $form->handleRequest($request)->shouldBeCalled();
        $form->isValid()->shouldBeCalled()->willReturn(true);

        $fileBag->get('image')->shouldBeCalled()->willReturn($image);
        $request->files = $fileBag;

        $mediaFactory->create($image)->shouldBeCalled()->willReturn($media);
        $uploader->upload($media)->shouldBeCalled();
        $organization->setImage($media)->shouldBeCalled()->willReturn($organization);

        $manager->persist($organization)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->handleForm($request, $organization, []);
    }
}
