<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Debug\Exception;

class RegistrationController extends FOSRestController //Controller
{
	/**
	* @Rest\View(statusCode=Response::HTTP_CREATED)
	* @Rest\Post("/register")
	* @Route("/register", name="user_registration")
	*/
	public function registerAction(Request $request)
	{
		$user = new User();
		$password = $this->get('security.password_encoder')
				->encodePassword($user, $user->getPlainPassword());
		$user->setPassword($password);
		$form = $this->createForm(UserType::class, $user);
		$form->submit($request->request->all());

		$repository = $this->getDoctrine()
			->getManager()->getRepository('AppBundle:User');
		$list = $repository->findAll();
		$exist = false;
		echo '<p>DB : <br /></p>';
		foreach ($list as $us) {
			echo '<p> username : '
			.$us->getUsername().' email :'.$us->getEmail().'</p>';
			if ($user->getUsername() === null
				|| $user->getEmail() === null 
				|| $us->getUsername() == $user->getUsername()
				|| $us->getEmail() == $user->getEmail()) {
					$exist = true;
				}
		}

		if ($exist == true) {
			$view = $this->view(array(
			'Error' => 'account not set or already exist.'), 500);

			return $this->handleView($view);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($user);
		$em->flush();

		echo '<p>New : <br /></p>';

		$data = array(
			'username' => $request->get('username'), 
			'email' => $request->get('email'),
			'password' => $password
			);
		$view = $this->view($data, 200);

		return $this->handleView($view);
	}
}
?>