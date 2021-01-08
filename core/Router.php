<?php
/**
 * Class Router
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core
 */

namespace protonx\basemvc\core;

use protonx\basemvc\core\exceptions\NotFoundException;

class Router 
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response) 
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback) 
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback) 
    {
        $this->routes['post'][$path] = $callback;
    }

    // http://localhost:3000/fabian?hallo=1
    // Prüft den Eingangs-Path und ruft
    // den gewünschten Controller auf.
    // Parameter für Aufruf: Request-Object
    public function resolve() 
    {
        // Gibt alle Route aus
        // echo '<pre>';
        // var_dump($this->routes);  
        // echo '</pre>';

        // Holt den Pfad zu dem navigiert wird
        $path = $this->request->getPath();

        // Welches HTTP-Verb hat die Anfrage
        $method = $this->request->getMethod();

        //  wenn assets angefordert werden
        if(stripos($path, '/assets', 0) === 0) return;

        // Gibt den Callback für die Anfrage zurück
        $callback = $this->routes[$method][$path] ?? false;

        if(!$callback)
        {
            throw new NotFoundException();
        }

        if(is_string($callback))
        {
            return Application::$app->view->renderView($callback);
        }

        if(is_array($callback))
        {
            // Eine Instanz des Controllers zentral
            // in der Applikation vermerken
            //** @var \app\core\Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller; 
            $controller->action = $callback[1];

            // Das instanzierte Objekt ersetzten,
            // damit die Methode (nicht statisch) aufgerufen
            // werden kann.
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) 
            {
                $middleware->execute();
            }
        }

        // Aufruf der Action auf Controller in $callback und
        // Übergabe der Parameter (request, response)
        return call_user_func($callback, $this->request, $this->response); 
    }
}