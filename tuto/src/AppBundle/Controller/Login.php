<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class Login
{
	/**
	* @Route("/login")
	*/
	public function indexAction()
	{
		return new Response(
		'<html><body>Login: <body/><html/>');
	}
}