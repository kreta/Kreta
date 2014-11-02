<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\Twig;

use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\StatusInterface;

/**
 * Class IssueExtension.
 *
 * @package Kreta\Bundle\WebBundle\Twig
 */
class IssueExtension extends \Twig_Extension
{
    /**
     * @{@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('issue_type', array($this, 'typeFilter'), array('is_safe' => array('all'))),
            new \Twig_SimpleFilter('issue_priority', array($this, 'priorityFilter'), array('is_safe' => array('all'))),
            new \Twig_SimpleFilter('issue_status', array($this, 'statusFilter'), array('is_safe' => array('all')))
        );
    }

    /**
     * Renders the label to represent the given type.
     *
     * @param integer $type Issue type to be rendered
     *
     * @return string Generated raw HTML
     */
    public function typeFilter($type)
    {
        switch ($type) {
            case IssueInterface::TYPE_BUG:
                $icon = 'fa fa-bug';
                $color = 'red';
                $text = 'Bug';
                break;
            case IssueInterface::TYPE_NEW_FEATURE:
                $icon = 'fa fa-plus';
                $color = 'green';
                $text = 'New feature';
                break;
            case IssueInterface::TYPE_IMPROVEMENT:
                $icon = 'fa fa-expand';
                $color = 'blue';
                $text = 'Improvement';
                break;
            case IssueInterface::TYPE_EPIC:
                $icon = 'fa fa-bolt';
                $color = 'purple';
                $text = 'Epic';
                break;
            case IssueInterface::TYPE_STORY:
                $icon = 'fa fa-lightbulb-o';
                $color = 'yellow';
                $text = 'Story';
                break;
            default:
                return '';
        }
        $label = '<div class="kreta-type-icon kreta-icon-item ' . $color . '">';
        $label .= '  <i class="fa ' . $icon . '" ></i >';
        $label .= '  <span class="kreta-icon-item-legend" >' . $text . '</span></div>';

        return $label;
    }

    /**
     * Renders the label to represent the given priority.
     *
     * @param integer $priority Issue priority to be rendered
     *
     * @return string Generated raw HTML
     */
    public function priorityFilter($priority)
    {
        switch($priority) {
            case IssueInterface::PRIORITY_BLOCKER:
                $icon = 'fa fa-ban';
                $color = 'red';
                $text = 'Blocker';
                break;
            case IssueInterface::PRIORITY_HIGH:
                $icon = 'fa fa-arrow-up';
                $color = 'red';
                $text = 'High';
                break;
            case IssueInterface::PRIORITY_MEDIUM:
                $icon = 'fa fa-arrow-left';
                $color = 'yellow';
                $text = 'Medium';
                break;
            case IssueInterface::PRIORITY_LOW:
                $icon = 'fa fa-arrow-down';
                $color = 'green';
                $text = 'Low';
                break;
            default:
                return '';
        }

        $label = '<div class="kreta-priority-icon kreta-icon-item ' . $color . '">';
        $label .= '  <i class="fa ' . $icon . '" ></i >';
        $label .= '  <span>' . $text . '</span></div>';

        return $label;
    }

    /**
     * Renders the label to represent the given status.
     *
     * @param StatusInterface $status Status to be rendered.
     *
     * @return string Generated raw HTML.
     */
    public function statusFilter(StatusInterface $status)
    {
        $label = '<div class="kreta-icon-item" style="background: ' . $status->getColor() . '">';
        $label .= '<span class="kreta-icon-item-legend">'. $status->getName() .'</span>';
        $label .= '</div>';

        return $label;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'issue_extension';
    }
}
