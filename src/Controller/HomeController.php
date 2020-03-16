<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{

    /**
     * @return Response
     * @Route("/",name="home.index")
     */
    public function index() {
        return new Response('Hello World');
    }
}