<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

// login avec ma méthode -> pas de token, et test tous les user, pas génial
class LoginController extends FOSRestController
{
	/**
	* @Rest\View(statusCode=Response::HTTP_CREATED)
	* @Rest\Post("/login2")
	* @Route("/login2", name="user_login")
	*/
	public function loginAction(Request $request)
	{
		$user = new User();
		if ($request->get('username') == null || $request->get('password') == null) {
			$view = $this->view(array(
			'Error' => 'Please enter username and passsword.'), 500);

			return $this->handleView($view);
		}
		$user->setUsername($request->get('username'));
		$user->setPassword($request->get('password'));

		$repository = $this->getDoctrine()
			->getManager()->getRepository('AppBundle:User');
		$list = $repository->findAll();
		$goodpass = false;
		foreach ($list as $us) {
			if ($us->getUsername() == $user->getUsername()) {
				$encoder = $this->get('security.password_encoder');
				if ($encoder->isPasswordValid($us, $user->getPassword())) {
					$goodpass = true;
				}
			}
		}

		if ($goodpass == false) {
			$view = $this->view(array(
			'Error' => 'Invalid username or password.'), 500);

			return $this->handleView($view);
		}
		$view = $this->view(array(
		'Connected' => $user->getUsername()), 200);

		return $this->handleView($view);
	}
}
?>