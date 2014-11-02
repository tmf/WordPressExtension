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
class FeatureListener implements EventSubscriberInterface
{
    private $wordpressParams;
    private $minkParams;

    /**
     * @param $wordpressParams
     * @param $minkParams
     */
    public function __construct($wordpressParams, $minkParams)
    {
        $this->wordpressParams = $wordpressParams;
        $this->minkParams = $minkParams;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            FeatureTested::BEFORE => array('beforeFeatureTested'),
        );
    }

    /**
     * @param BeforeFeatureTested $event
     */
    public function beforeFeatureTested(BeforeFeatureTested $event)
    {
        $url = parse_url($this->minkParams['base_url']);

        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['HTTP_HOST'] = $url["host"];
        $PHP_SELF = $GLOBALS['PHP_SELF'] = $_SERVER['PHP_SELF'] = '/index.php';

        define('WP_INSTALLING', true);
        require_once $this->wordpressParams['path'] . '/wp-config.php';
    }
}
