<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\User\Model;

use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class UserSpec.
 *
 * @package spec\Kreta\Component\User\Model
 */
class UserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\User\Model\User');
    }

    function it_extends_fos_user_model()
    {
        $this->shouldHaveType('FOS\UserBundle\Model\User');
    }

    function it_implements_user_interface()
    {
        $this->shouldImplement('Kreta\Component\User\Model\Interfaces\UserInterface');
    }

    function it_should_not_have_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function its_created_at_is_a_datetime()
    {
        $this->getCreatedAt()->shouldHaveType('DateTime');
    }

    function its_bitbucket_access_token_is_mutable()
    {
        $this->setBitbucketAccessToken('the-dummy-bitbucket-access-token')->shouldReturn($this);
        $this->getBitbucketAccessToken()->shouldReturn('the-dummy-bitbucket-access-token');
    }

    function its_bitbucket_id_is_mutable()
    {
        $this->setBitbucketId('the-dummy-bitbucket-id')->shouldReturn($this);
        $this->getBitbucketId()->shouldReturn('the-dummy-bitbucket-id');
    }

    function its_created_at_is_mutable()
    {
        $createDate = new \DateTime();

        $this->setCreatedAt($createDate)->shouldReturn($this);
        $this->getCreatedAt()->shouldReturn($createDate);
    }

    function its_first_name_is_mutable()
    {
        $this->setFirstName('The dummy first name')->shouldReturn($this);
        $this->getFirstName()->shouldReturn('The dummy first name');
    }

    function its_full_name_returns_null_if_first_name_and_last_name_are_null()
    {
        $this->getFullName()->shouldReturn(null);
    }

    function its_full_name_returns_last_name_if_first_name_is_null()
    {
        $this->setLastName('surname')->shouldReturn($this);

        $this->getFullName()->shouldReturn('surname');
    }

    function its_full_name_returns_first_name_if_last_name_is_null()
    {
        $this->setFirstName('name')->shouldReturn($this);

        $this->getFullName()->shouldReturn('name');
    }

    function its_full_name_returns_first_name_plus_last_name_if_it_is_default_situation()
    {
        $this->setFirstName('name')->shouldReturn($this);
        $this->setLastName('surname')->shouldReturn($this);

        $this->getFullName()->shouldReturn('name surname');
    }

    function its_github_access_token_is_mutable()
    {
        $this->setGithubAccessToken('the-dummy-github-access-token')->shouldReturn($this);
        $this->getGithubAccessToken()->shouldReturn('the-dummy-github-access-token');
    }

    function its_github_id_is_mutable()
    {
        $this->setGithubId('the-dummy-github-id')->shouldReturn($this);
        $this->getGithubId()->shouldReturn('the-dummy-github-id');
    }

    function its_last_name_is_mutable()
    {
        $this->setLastName('The dummy last name')->shouldReturn($this);
        $this->getLastName()->shouldReturn('The dummy last name');
    }

    function its_photo_is_mutable(MediaInterface $media)
    {
        $this->setPhoto($media)->shouldReturn($this);
        $this->getPhoto()->shouldReturn($media);
    }

    function its_email_has_the_same_value_than_username()
    {
        $this->getUsername()->shouldReturn(null);
        $this->setEmail('dummy@email.com')->shouldReturn($this);
        $this->getUsername()->shouldReturn('dummy@email.com');
    }

    function its_email_canonical_has_the_same_value_than_username_canonical()
    {
        $this->getUsernameCanonical()->shouldReturn(null);
        $this->setEmailCanonical('dummy@email-canonical.com')->shouldReturn($this);
        $this->getUsernameCanonical()->shouldReturn('dummy@email-canonical.com');
    }
}
