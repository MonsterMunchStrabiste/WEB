<?php

namespace WEB\CrowdBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	public function indexAction($name)
	{
		return $this->render('WEBCrowdBundle:Default:index.html.twig', array('name' => $name));
	}
	public function numberAction($number)
	{
		if ($number < 1) {
			throw $this->createNotFoundException("La page ".$number." n'existe pas.");
		}
		return $this->render('WEBCrowdBundle:Default:index.html.twig', array('name' => $number));
	}
}
