<?php
/**
 * Class Response
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core
 */

 namespace protonx\basemvc\core;

 class Response 
 {
    public function __construct() {}

    public function setStatusCode(int $code)
    {
        http_response_code($code); // native funktion
    }

    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }
}