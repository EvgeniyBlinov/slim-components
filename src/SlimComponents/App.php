<?php
namespace SlimComponents;

/**
 * App
 *
 * @package slim-components
 * @author Evgeniy Blinov <evgeniy_blinov@mail.ru>
**/
class App
{
    /**
     * @var array
     **/
    protected static $apps;

    private function __clone()    { /* ... @return App */ }
    private function __wakeup()   { /* ... @return App */ }

    /**
     * Constructor
     * @param string $name
     **/
    private function __construct($name = 'default')
    {
        if (is_null(static::getInstance())) {
            $this->setName($name);
        }
    }

    /**
     * Get application instance by name
     * @param  string    $name The name of the Slim application
     * @return App|null
     */
    public static function getInstance($name = 'default')
    {
        return isset(static::$apps[$name]) ? static::$apps[$name] : null;
    }

    /**
     * Set Slim application name
     * @param  string $name The name of this Slim application
     */
    public function setName($name)
    {
        static::$apps[$name] = $this;
    }

    /**
     * Set app
     *
     * @param string $name
     * @param object $app
     * @return void
     **/
    public static function setApp($name, $app)
    {
        static::$apps[$name] = $app;
    }
}
