<?php
namespace SlimComponents;

/**
 * Config
 *
 * @package slim-components
 * @author Evgeniy Blinov <evgeniy_blinov@mail.ru>
**/
class Config 
{
    /**
     * @var string
     **/
    static $env = 'production';
    /**
     * @var array
     **/
    static $confArray;

    /**
     * @return mixed of config param by name
     */
    public static function read($name) 
    {
        return self::$confArray[$name];
    }

    /**
     * Write config param by name
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public static function write($name, $value)
    {
        self::$confArray[$name] = $value;
    }

    /**
     * Read from alias
     *
     * @param string $alias
     * @return mixed of config param by alias
     */
    public static function readFromAlias($alias)
    {
        $aliasParams = explode('.', $alias);

        $result = self::$confArray[self::$env];
        foreach ($aliasParams as $aliasParam) {
            if (isset($result[$aliasParam])) {
                $result = $result[$aliasParam];
            } else {
                return null;
            }
        }

        return $result;
    }
}
