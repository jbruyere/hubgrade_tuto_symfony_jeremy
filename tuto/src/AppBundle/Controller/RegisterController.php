<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Log;

class RegisterController extends Controller
{
	/**
	* @Route("/register")
	*/
	public function indexAction()
	{
		if (isset($_POST['login']) AND isset($_POST['password']))
		{
			$log = new Log();
			$log->setLogin($_POST['login']);
			$log->setPassword($_POST['password']);
			$log->setPublished(true);

			$em = $this->getDoctrine()->getManager();
			$em->persist($log);
			$em->flush();
			$str = '<p>'.$_POST['login'].' Registered</p>';
		}
		else
		{
			$str = '<p> Not connected </p>';
		}

		return new Response(
		'<html>
			<body>
				<form method="post" action="register">
					<p>
						New Login: <input type="text" name="login"/>
						New Password: <input type="password" name="password" />
						<input type="submit" value="Register" />
					</p>
				</form>
			'.$str.'
			</body>
		</html>'
		);
	}
}