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

class NotificationExtension extends \Twig_Extension
{
    protected $events = array (
        'issue_new' => array (
            'icon' => 'fa-check-square-o',
            'color' => 'green'
        )
    );

    /**
     * @{@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('notificationIcon', [$this, 'iconFilter'], ['is_safe' => ['all']]),
        ];
    }

    /**
     * Renders the icon with its color according the configuration
     *
     * @param string $type Event type to be rendered
     *
     * @return string Generated raw HTML
     */
    public function iconFilter($type)
    {
        if(isset($this->events[$type])) {
            $event = $this->events[$type];
            $icon = '<div class="kreta-notification-icon kreta-icon-item ' . $event['color'] . '">';
            $icon .= '  <i class="fa ' . $event['icon'] . '" ></i >';
            $icon .= '</div>';
            return $icon;
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'notification_extension';
    }
} 
