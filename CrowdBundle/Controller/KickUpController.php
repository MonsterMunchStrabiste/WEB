<?php

namespace WEB\CrowdBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class KickUpController extends Controller
{
    public function indexAction()
    {
        return $this->render('WEBCrowdBundle:KickUp:index.html.twig');
    }
    public function aboutAction()
    {
        return $this->render('WEBCrowdBundle:KickUp:about.html.twig');
    }
        public function contactAction()
    {
        return $this->render('WEBCrowdBundle:KickUp:contact.html.twig');
    }
}
