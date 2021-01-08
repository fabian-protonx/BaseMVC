<?php
/**
 * Class View
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core
 */

 namespace protonx\basemvc\core;

 use protonx\basemvc\core\Application;

 class View 
 {
    public string $title = '';

    public function __construct() {}

    public function renderView($view, $params = [])
    {
        // dieser Aufruf muss zuerst erfolgen, 
        // damit die gesetzten Variablen im spezifischen Layout
        // gesetzt werden.
        $viewContent = $this->renderOnlyView($view, $params); 
        $layoutContent = $this->layoutContent();

        return str_replace('{{CONTENT}}', $viewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        $layout = Application::$app->layout;
        if(Application::$app->controller)
        {
            $layout = Application::$app->controller->layout;
        }

        ob_start(); // start output cashing
        include_once Application::$ROOT_DIR . "/views/layouts/" . $layout . ".php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            // Der doppelte $ erstellt eine Variable mit dem Namen von $key
            // und weist der Variable den Wert $value zu.
            // Damit können in der View die Variable normal genutzt werden.
            $$key = $value;
        }

        ob_start(); // start output cashing
        include_once Application::$ROOT_DIR . "/views/" . $view .".php";
        return ob_get_clean();
    }
}