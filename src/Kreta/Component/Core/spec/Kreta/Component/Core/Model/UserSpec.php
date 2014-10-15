<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Model;

use PhpSpec\ObjectBehavior;

/**
 * Class UserSpec.
 *
 * @package spec\Kreta\Component\Core\Model
 */
class UserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\User');
    }

    function it_extends_fos_user_model()
    {
        $this->shouldHaveType('FOS\UserBundle\Model\User');
    }

    function it_implements_user_interface()
    {
        $this->shouldImplement('Kreta\Component\Core\Model\Interfaces\UserInterface');
    }

    function its_created_at_is_mutable()
    {
        $createDate = new \DateTime();

        $this->setCreatedAt($createDate)->shouldReturn($this);
        $this->getCreatedAt()->shouldReturn($createDate);
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

    function its_first_name_is_mutable()
    {
        $this->setFirstName('The dummy first name')->shouldReturn($this);
        $this->getFirstName()->shouldReturn('The dummy first name');
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
