<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\ContactForm;
use App\Core\Controller;
use App\Core\Exception\MailNotSentException;
use App\Core\FormValidator\ContactFormValidator;
use App\Core\Request;
use App\Core\Response;
use App\Core\Service\EmailSender;

class SiteController extends Controller {

    public function home()
    {
        return $this->render('home');
    }


    public function contact(Request $request)
    {
        $emailSender = new EmailSender();
        $contactForm = new ContactForm();
        $contactFormValidator = new ContactFormValidator();

        if($request->isPost() && $contactFormValidator->validate($request)) {
            $contactForm->loadData($request->getBody());
            $emailSender->send($contactForm->email, $contactForm->name, $contactForm->subject, $contactForm->body);

            Application::$app->session->setFlash('success', 'Your email was successfully sent !');
            Application::$app->response->redirect('/');
            exit();
        }

        return $this->render('contact', [
            'model' => $contactForm,
            'errors' => $contactFormValidator->getErrors()
        ]);
    }
}