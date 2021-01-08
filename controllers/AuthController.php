<?php
/**
 * Class AuthController
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\controllers
 */

 namespace protonx\basemvc\controllers;

 use protonx\basemvc\core\Application;
 use protonx\basemvc\core\Controller;
 use protonx\basemvc\core\Request;
 use protonx\basemvc\core\Response;
 use protonx\basemvc\models\User;
 use protonx\basemvc\models\LoginForm;
 use protonx\basemvc\core\middlewares\AuthMiddleware;

 class AuthController extends Controller
 {
    public function __construct() 
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request, Response $response)
    {
        $this->setLayout('auth');

        $loginForm = new LoginForm();

        if($request->isPost())
        {
            $loginForm->loadData($request->getBody());

            if($loginForm->validate() && $loginForm->login())
            {
                $response->redirect('/');

                return;
            }
        }

        return $this->render('login', [
            'model' => $loginForm
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();

        $response->redirect('/');
    }

    public function register(Request $request, Response $response)
    {
        $this->setLayout('auth');

        $user = new User();

        if($request->isPost())
        {
            $user->loadData($request->getBody());

            if($user->validate() && $user->save()) 
            {
                $msg = 'Vielen Dank für die Registrierung.';
                Application::$app->session->setFlash('success', $msg);

                $response->redirect('/');

                exit();
            }
        }

        return $this->render('register', [
            'model' => $user
        ]);
    }

    public function profile(Request $request, Response $response)
    {
        return $this->render('profile', []);
    }
}