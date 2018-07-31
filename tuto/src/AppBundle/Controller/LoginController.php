<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Log;

class LoginController extends Controller
{
	/**
	* @Route("/login")
	*/
	public function indexAction()
	{
		if (isset($_POST['login']) AND isset($_POST['password']))
		{
			$str = '<p> Wrong login or password.</p>';
			$repository = $this->getDoctrine()
			->getManager()->getRepository('AppBundle:Log');
			$list = $repository->findAll();
			foreach ($list as $login) {
				if ($login->getLogin() == $_POST['login'] AND $login->getPassword() == $_POST['password'])
				{
					$str = '<p>'.$_POST['login'].' Connected</p>';
				}
			}
		}
		else
		{
			$str = '<p> Not connected </p>';
		}

		return new Response(
		'<html>
			<body>
				<form method="post" action="login">
					<p>
						Login: <input type="text" name="login"/>
						Password: <input type="password" name="password" />
						<input type="submit" value="Login" />
					</p>
				</form>
			'.$str.'
			</body>
		</html>'
		);
	}
}