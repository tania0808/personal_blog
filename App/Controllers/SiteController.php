<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;

class SiteController extends Controller {

    public function home()
    {
        return $this->render('home');
    }
    public function contact()
    {
        return $this->render('contact');
    }
    public function handleContact(Request $request)
    {
        $body = $request->getBody();
        var_dump($body);
        return 'Handling Submitted Data';
    }
}