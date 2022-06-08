<?php
class URL
{
    public static function createLink($module, $controller, $action, $param = null)
    {
        $paramLink = '';
        if (!empty($param)) {
            foreach ($param as $key => $value) {
                $paramLink .= "&$key=$value";
            }
        }
        $url = "index.php?module=$module&controller=$controller&action=$action" . $paramLink;
        return $url;
    }

    public static function redirectLink($module, $controller, $action)
    {
        $url = "index.php?module=$module&controller=$controller&action=$action";
        header('location: ' . $url);
        exit();
    }

    public static function requestURI($param = null){
        $uri = $_SERVER['REQUEST_URI'];
        $paramLink = '';
        if (!empty($param)) {
            foreach ($param as $key => $value) {
                $paramLink .= "&$key=$value";
            }
        }
        $url = $paramLink;
        return $uri;
    }
}
