<?php
/**
 * Class BaseMiddleware
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core\middlewares
 */

namespace protonx\basemvc\core\middlewares;

abstract class BaseMiddleware 
{
    abstract public function execute();
}