<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\ContactForm;

class PostController extends Controller {

    public function home()
    {
        return $this->render('home');
    }
    public function contact(Request $request, Response $response)
    {
        $contactForm = new ContactForm();

        if($request->isPost()) {
            $contactForm->loadData($request->getBody());
            if($contactForm->validate() && $contactForm->sendMail()) {
                Application::$app->session->setFlash('success', 'Your email was successfully sent !');
                Application::$app->response->redirect('/');
                exit();
            }
        }

        return $this->render('contact', [
            'model' => $contactForm,
        ] );
    }
}