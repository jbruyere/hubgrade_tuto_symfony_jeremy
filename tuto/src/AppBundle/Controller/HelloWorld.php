<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class HelloWorld
{
	/**
	* @Route("/hello-world")
	*/
	public function number()
	{
		$number = mt_rand(0, 100);

		return new Response(
		'<html><body>Hello world ! <br />Lucky number: '.$number.'</body></html>'
		);
	}
}