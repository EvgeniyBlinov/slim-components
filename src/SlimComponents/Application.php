<?php
namespace SlimComponents;

use Slim\Helper\Set;
use Symfony\Component\Console\Application as BaseApplication;

/**
 * Application
 *
 * @package slim-components
 * @require "symfony/console" : "*",
 * @author Evgeniy Blinov <evgeniy_blinov@mail.ru>
**/
class Application extends BaseApplication
{
    /**
     * @var \Slim\Helper\Set
     */
    public $container;

    /**
     * Constructor.
     *
     * @param string $name    The name of the application
     * @param string $version The version of the application
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        $this->container = new Set();
        return parent::__construct();
    }
}
