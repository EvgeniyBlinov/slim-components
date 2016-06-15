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
        return self::arrDotAccess($alias, self::$confArray[self::$env]);
    }

    /**
     * Array dot access
     *
     * @param string $alias
     * @param array $array
     * @return mixed
     * @author Evgeniy Blinov <evgeniy_blinov@mail.ru>
     **/
    public static function arrDotAccess($alias, $array)
    {
        $indexes = explode('.', $alias);
        for ($i = 0, $limit = count($indexes); $i < $limit; $i++) {
            $subAlias = implode('.', array_slice($indexes, 0, $i+1));
            $alias    = substr($alias, strlen($subAlias)+1);
            if (isset($array[$subAlias])) {
                if (empty($alias)) {
                    return $array[$subAlias];
                }
                return self::arrDotAccess($alias, $array[$subAlias]);
            }
        }
        return null;
    }
}
