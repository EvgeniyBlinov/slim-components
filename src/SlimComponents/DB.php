<?php
namespace SlimComponents;

use SlimComponents\Config;
use PDO;

/**
 * DB
 *
 * @package slim-components
 * @require PDO
 * @author Evgeniy Blinov <evgeniy_blinov@mail.ru>
**/
class DB
{
    /**
     * @var handle
     **/
    public $dbh; // handle of the db connexion
    /**
     * @var Core
     **/
    private static $instance;
    /**
     * @var Callable
     **/
    protected $dbFallback;

    /**
     * @return Core
     */
    public static function getInstance() 
    {
        if (!isset(self::$instance)) {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() 
    {
        $dbConfig = Config::readFromAlias('db');
        if (!$dbConfig) {
            throw new \Exception('DB config not found!');
        }

        $dsnParams = array_intersect_key(
            $dbConfig['mysql']['connect'],
            array_flip($this->getDSNAvailableParams())
        );

        try {
            $this->dbh = new PDO(
                sprintf('mysql:%s', http_build_query($dsnParams, null, ';')),
                $dbConfig['mysql']['connect']['user'],
                $dbConfig['mysql']['connect']['password']
            );
            if (defined('DEBUG') || defined('APP_DEBUG')) {
                $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
        } catch (\Exception $e) {
            if ($this->dbFallback) {
                call_user_func_array($this->dbFallback, array($this, $e));
            }
        }
    }

    /**
     * Set DB fallback
     *
     * @param Callable $callable
     * @return DB
     * @author Evgeniy Blinov <evgeniy_blinov@mail.ru>
     **/
    public function setDBFallback(Callable $callback)
    {
        $this->dbFallback = $callback;
        return $this;
    }

    /**
     * @return array of DSN available params
     */
    public function getDSNAvailableParams()
    {
        return array(
            'host',
            'port',
            'dbname',
            'unix_socket',
            'charset',
        );
    }
}
