<?php

namespace Sugarcrm\XHProf\Viewer\Templates\Helpers;


use Sugarcrm\XHProf\Viewer\Controllers\AbstractController;

class CurrentPage
{
    /**
     * @var AbstractController
     */
    protected static $currentController;

    /**
     * @return AbstractController
     */
    public static function getCurrentController()
    {
        return self::$currentController;
    }

    /**
     * @param AbstractController $currentController
     */
    public static function setCurrentController($currentController)
    {
        self::$currentController = $currentController;
    }

    public static function url($override = array(), $drop = array())
    {
        return Url::url(static::getParams($override, $drop));
    }

    public static function getParams($override = array(), $drop = array())
    {
        $controller = static::getCurrentController();
        $params = array();
        $list = $controller->getParamsList();
        foreach ($list as $param) {
            $params[$param] = $controller->getParam($param);
        }

        foreach ($override as $key => $value) {
            $params[$key] = $value;
        }

        $defaults = $controller->getParamDefaults();
        foreach ($params as $param => $value) {
            if (isset($defaults[$param]) && $defaults[$param] == $value) {
                $drop[] = $param;
            }
        }

        foreach ($drop as $param) {
            unset($params[$param]);
        }

        return $params;
    }

    public static function getParam($name)
    {
        return static::getCurrentController()->getParam($name);
    }
}
