<?php

namespace Bench\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HelloController extends Controller
{
    public function indexAction()
    {
        return $this->render('HelloBundle:Hello:index.html.twig');
    }
    
    public function welcomeAction()
    {
        return $this->render('HelloBundle:Hello:welcome.html.twig');
    }
}
