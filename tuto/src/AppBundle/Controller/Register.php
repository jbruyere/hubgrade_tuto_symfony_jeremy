<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class Register
{
	/**
	* @Route("/register")
	*/
	public function indexAction()
	{
		return new Response(
		'<html><body>Register: <body/><html/>');
	}
}