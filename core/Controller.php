<?php
/**
 * Class Controller
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core
 */

 namespace protonx\basemvc\core;

 use protonx\basemvc\core\Application;
 use protonx\basemvc\core\middlewares\BaseMiddleware;

 class Controller 
 {
    public string $layout = 'main';
    public string $action = '';

    /**
     * @var \protonx\basemvc\core\middlewares\BaseMiddleware[]
     */
    public array $middlewares = [];

    protected function __construct() {}

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array 
    {
        return $this->middlewares;
    }
}