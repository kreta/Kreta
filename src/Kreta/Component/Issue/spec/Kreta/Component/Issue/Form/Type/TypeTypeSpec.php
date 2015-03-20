<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Issue\Form\Type;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TypeTypeSpec.
 *
 * @package spec\Kreta\Component\Issue\Form\Type
 */
class TypeTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Issue\Form\Type\TypeType');
    }

    function it_extends_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_sets_default_options(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('choices', [
            IssueInterface::TYPE_BUG         => 'Bug',
            IssueInterface::TYPE_NEW_FEATURE => 'New feature',
            IssueInterface::TYPE_IMPROVEMENT => 'Improvement',
            IssueInterface::TYPE_EPIC        => 'Epic',
            IssueInterface::TYPE_STORY       => 'Story'
        ]))->shouldBeCalled()->willReturn($resolver);

        $this->setDefaultOptions($resolver);
    }

    function it_gets_parent()
    {
        $this->getParent()->shouldReturn('choice');
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_issue_type_type');
    }
}
