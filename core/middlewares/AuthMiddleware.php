<?php
/**
 * Class AuthMiddleware
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core\middlewares
 */

namespace protonx\basemvc\core\middlewares;

use protonx\basemvc\core\Application;
use protonx\basemvc\core\exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware 
{
    public array $actions = [];

    public function __construct(array $actions = []) 
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if(Application::isGuest())
        {
            if(empty($this->actions) || in_array(Application::$app->controller->action, $this->actions))
            {
                throw new ForbiddenException();
            }
        }
    }
}