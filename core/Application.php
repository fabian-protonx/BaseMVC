<?php
/**
 * Class Application
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core
 */

///////////////////////////////////////////////////
///////////////////////////////////////////////////
///////////////////////////////////////////////////
//// set_exception_handler()
//// https://www.php.net/manual/de/function.set-exception-handler.php
///////////////////////////////////////////////////
///////////////////////////////////////////////////
///////////////////////////////////////////////////

namespace protonx\basemvc\core;

use protonx\basemvc\core\database\Database;

class Application  
{
    public static $CONFIG;
    public static string $ROOT_DIR;
    public static Application $app;

    public View $view;
    public Database $db;
    public Router $router;
    public Session $session;
    public Request $request;
    public string $userClass;
    public Response $response;
    public ?UserModel $user = null;
    public string $layout = 'main';
    public ?Controller $controller = null;

    public function __construct($rootPath) 
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        self::$CONFIG = Configuration::getConfig();

        $this->userClass = self::$CONFIG['UserClass'];

        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database();
        $this->view = new View();

        // ----------------------------------------------------
        // Benutzer laden
        // (sofern er schon eine Session hat)
        // ----------------------------------------------------

        $primaryValue = $this->session->get('user');

        if($primaryValue)
        {
            $primaryKey = $this->userClass::primaryKey();

            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        }
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);

        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function run()
    {
        try 
        {
            echo $this->router->resolve();
        } 
        catch (\Exception $exception) // Throwable $th
        {
            $this->response->setStatusCode($exception->getCode());

            echo $this->view->renderView('lapse', [
                'exception' => $exception
            ]);
        }
    }
}