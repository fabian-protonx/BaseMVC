<?php
/**
 * Class ShowVariables
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core
 */

namespace protonx\basemvc\core;

class ShowVariables 
{
    public function __construct() {}

    public static function dump($value)
    {
        echo '<pre>';
        var_dump($value);  
        echo '</pre>';
    }

    public static function showEnvironmentVariables()
    {
        echo '<pre>';
        var_dump($_SERVER);
        // print_r($GLOBALS);
        echo '<pre>';
        exit;

        // 'REQUEST_URI' => string '/' (length=1)
        // 'REQUEST_URI' => string '/contact' (length=8)
        // 'REQUEST_URI' => string '/users?id=1' (length=11)
        // 'HTTP_X_ORIGINAL_URL' => string '/users?id=1' (length=11)

        // 'QUERY_STRING' => string 'id=1' (length=4)

        // 'REQUEST_METHOD' => string 'GET' (length=3)
        // 'DOCUMENT_ROOT' => string 'C:\HOME\002_Sandkasten_NEU\122_PHP_MVC_Framework'
        // 'ORIG_PATH_INFO' => string '/index.php' (length=10)
        // 'URL' => string '/index.php' (length=10)
        // 'REQUEST_TIME' => int 1603982185
    }

    public static function parseCurrentUrl()
    {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ||
            $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        echo $url . EOL; 
        echo 'PHP_URL_SCHEME:  ' . parse_url($url, PHP_URL_SCHEME) . EOL;
        echo 'PHP_URL_USER:  ' . parse_url($url, PHP_URL_USER) . EOL;
        echo 'PHP_URL_PASS:  ' . parse_url($url, PHP_URL_PASS) . EOL;
        echo 'PHP_URL_HOST:  ' . parse_url($url, PHP_URL_HOST) . EOL;
        echo 'PHP_URL_PORT:  ' . parse_url($url, PHP_URL_PORT) . EOL;
        echo 'PHP_URL_PATH:  ' . parse_url($url, PHP_URL_PATH) . EOL;
        echo 'PHP_URL_QUERY:  ' . parse_url($url, PHP_URL_QUERY) . EOL;
        echo 'PHP_URL_FRAGMENT:  ' . parse_url($url, PHP_URL_FRAGMENT) . EOL;
    }
}