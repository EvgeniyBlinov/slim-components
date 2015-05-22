<?php
namespace SlimComponents;

class TwigExtension 
{
    /**
     * @var \Slim\Slim
     **/
    private $_app;
    private $_twig;
    private $_options = array();
    private $_translations = array();

    /**
     * Constructor
     * 
     * @param \Slim\Slim $app
     * @param array $options
     */
    public function __construct(\Slim\Slim $app, $options = null)
    {
        $this->_app = $app;
        $this->_twig = $app->view->getInstance();
        $this->_twig->addGlobal('app', $this->_app);

        $this->_options = ($options != null) ? $options : $this->getDefaultOptions();

        /******************  Add filters  *************************************/
        $this->buildTranslations();
        $this->registerTranslations();
        /******************  Add filters  *************************************/

        /******************  Add functions  ***********************************/
        $this->registerPath();
        $this->registerDump();
        /******************  Add functions  ***********************************/
    }

    /**
     * @return array of default options
     */
    public function getDefaultOptions()
    {
        return array(
            'translations' => array('ru')
        );
    }

    /**
     * Build translations
     */
    public function buildTranslations()
    {
        foreach ($this->_options['translations'] as $language) {
            $this->_translations[$language] = require_once "../messages/{$language}.php";
        }
    }

    /**
     * Register trans
     */
    public function registerTranslations()
    {
        $trans = $this->_translations;
        $this->_twig->addFilter(new \Twig_SimpleFilter('trans', function ($message, $locale = APP_DEFAULT_LOCALE) use ($trans) {
            return (isset($trans[$locale]) && isset($trans[$locale][$message])) ? $trans[$locale][$message] : $message;
        }));
    }

    /**
     * Register path
     */
    public function registerPath()
    {
        $app = $this->_app;
        $this->_twig->addFunction(new \Twig_SimpleFunction('path', function ($route_name, $params = array()) use ($app) {
            return $app->urlFor($route_name, empty($params) ? array() : $params);
        }));
    }

    /**
     * Register dump
     */
    public function registerDump()
    {
        $this->_twig->addFunction(new \Twig_SimpleFunction('dump', function ($var) {
            return var_dump($var);
        }));
    }
}
