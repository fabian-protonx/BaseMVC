<?php
/**
 * Class SiteController
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\controllers
 */

 namespace protonx\basemvc\controllers;

 use protonx\basemvc\core\Application;
 use protonx\basemvc\core\Controller;
 use protonx\basemvc\core\Request;
 use protonx\basemvc\core\Response;
 use protonx\basemvc\models\ContactForm;

 class SiteController extends Controller
 {
    public function __construct() {}

    public function home()
    {
        $params = [
            'name' => "Protonx"
        ];

        return $this->render('home', $params);
    }

    public function contact(Request $request, Response $response)
    {
        $contactForm = new ContactForm();

        if($request->isPost())
        {
            $contactForm->loadData($request->getBody());

            if($contactForm->validate() && $contactForm->send())
            {
                Application::$app->session->setFlash('success', 'Die Mitteilung wurde versendet.');

                $response->redirect('/contact');

                return;
            }
        }

        return $this->render('contact', [
            'model' => $contactForm
        ]);
    }
}