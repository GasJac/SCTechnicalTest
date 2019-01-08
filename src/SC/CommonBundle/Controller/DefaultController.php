<?php

namespace SC\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SCCommonBundle:Default:index.html.twig');
    }
}
