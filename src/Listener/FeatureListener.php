<?php

namespace Tmf\WordPressExtension\Listener;

use Behat\Behat\EventDispatcher\Event\BeforeFeatureTested;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Behat\Behat\EventDispatcher\Event\FeatureTested;

/**
 * Class FeatureListener
 *
 * @package Tmf\WordPressExtension\Listener
 */
class FeatureListener implements  EventSubscriberInterface
{
    private $path;
    private $minkParams;

    /**
     * @param $path
     * @param $minkParams
     */
    public function __construct($path, $minkParams)
    {
        $this->path = $path;
        $this->minkParams = $minkParams;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        $events = array(
          FeatureTested::BEFORE => array('beforeFeatureTested'),
        );

        return array_combine($events, $events);
    }

    /**
     * @param BeforeFeatureTested $event
     */
    public function beforeFeature(BeforeFeatureTested $event)
    {
        $url = parse_url($this->minkParams["base_url"]);

        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['HTTP_HOST'] = $url["host"];
        $PHP_SELF = $GLOBALS['PHP_SELF'] = $_SERVER['PHP_SELF'] = '/index.php';

        define( 'WP_INSTALLING', true );
        require_once $this->path . '/wp-config.php';
    }
}
