<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\ContactForm;
use App\Core\Controller;
use App\Core\Exception\MailNotSentException;
use App\Core\FormValidator\ContactFormValidator;
use App\Core\Request;
use App\Core\Service\EmailSender;

class SiteController extends Controller
{
    public function home(): false|array|string
    {
        return $this->render('home');
    }

    /**
     * @throws MailNotSentException
     */
    public function contact(Request $request)
    {
        $emailSender = new EmailSender();
        $contactFormValues = new ContactForm();
        $contactFormValues->loadData($request->getBody());
        $contactFormValidator = new ContactFormValidator();

        if ($request->isPost() && $contactFormValidator->validate($request)) {
            $emailSender->send(
                $contactFormValues->getEmail(),
                $contactFormValues->getName(),
                $contactFormValues->getSubject(),
                $contactFormValues->getBody()
            );

            Application::$app->session->setFlash('success', 'Your email was successfully sent !');
            Application::$app->response->redirect('/');
            exit();
        }

        return $this->render('contact', [
            'model' => $contactFormValues,
            'errors' => $contactFormValidator->getErrors()
        ]);
    }
}
