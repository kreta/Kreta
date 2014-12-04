<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CoreBundle\Form\Type;

use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TypeTypeSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\Form\Type
 */
class TypeTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Form\Type\TypeType');
    }

    function it_extends_form_abstract_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_sets_defaults(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                IssueInterface::TYPE_STORY       => 'Story',
                IssueInterface::TYPE_BUG         => 'Bug',
                IssueInterface::TYPE_IMPROVEMENT => 'Improvement',
                IssueInterface::TYPE_NEW_FEATURE => 'New feature',
                IssueInterface::TYPE_EPIC        => 'Epic'
            )
        ))->shouldBeCalled();

        $this->setDefaultOptions($resolver);
    }

    function it_gets_parent()
    {
        $this->getParent()->shouldReturn('choice');
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_core_type_type');
    }
}
