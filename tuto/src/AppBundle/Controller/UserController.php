<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Entity\Lik;
use AppBundle\Entity\AuthToken;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Controller\Registration;
use AppBundle\Form\UserType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Debug\Exception;
use \DateTime;

class UserController extends FOSRestController
{
	/**
	* @Rest\View(statusCode=Response::HTTP_CREATED)
	* @Rest\Put("/user/profil")
	* @Route("/user/profil")
	*/
	// at least : token + things to update
	public function updateProfilAction(Request $request)
	{
		$em = $this->get('doctrine.orm.entity_manager');

		/*$tokenvalue = $request->headers->get('Authorization');
		
		$view = $this->view(array(
		'token' => substr($tokenvalue, 7)), 500);

		return $this->handleView($view);*/
		$user = $this->getDoctrine()
			->getRepository('AppBundle:User')->getUserFromToken($request, $em);
		if ($user == null || $user[0]['id'] == null) {
			return $this->invalidUser('User not connected.');
		}

		$token = new AuthToken();
		$tokenvalue = $request->headers->get('Authorization');
		if (strncmp($tokenvalue, 'Bearer ', 7) == 0) {
			$tokenvalue = substr($tokenvalue, 7);
		}
		$token = $em->getRepository('AppBundle:AuthToken')
			->findOneByValue($tokenvalue);
		$id = $token->getUser()->getId();
		$user = $em->getRepository('AppBundle:User')
            ->findOneById($id);

		$infos = array('id' => $user->getId());
		if ($request->get('bio') != null) {
			$user->setBio($request->get('bio'));
		}
		if ($request->get('pseudo') != null) {
			$user->setPseudo($request->get('pseudo'));
		}
		if ($request->get('phone') != null) {
			$user->setPhone($request->get('phone'));
		}
		if ($request->get('city') != null) {
			$user->setCity($request->get('city'));
		}
		if ($request->get('zipcode') != null) {
			$user->setZipcode($request->get('zipcode'));
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($user);
		$em->flush();

		
		$infokey = array('id', 'username', 'pseudo', 'email',
		'phone', 'city', 'zipcode', 'bio');
		$values = array($user->getId(), $user->getUsername(),
		$user->getPseudo(), $user->getEmail(),
		$user->getPhone(), $user->getCity(),
		$user->getZipcode(), $user->getBio());
		$i = 0;
		foreach ($infokey as $info) {
			if ($values[$i] != null) {
				$infos[$info] = $values[$i];
			}
			$i += 1;
		}
		/*$view = $this->view($infos, 200);
		return $this->handleView($view);*/
		$response = new Response();
		$response->setContent(json_encode($infos));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
		return $response;
	}

	/**
	* @Rest\View(statusCode=Response::HTTP_CREATED)
	* @Rest\Post("/profil")
	* @Route("/profil")
	*/
	// at least : username
	public function readProfilAction(Request $request)
	{
		if ($request->get('username') == null) {
			return $this->invalidUser('no username');
		}
		$user = $this->getDoctrine()
			->getRepository('AppBundle:User')
			->findUserByUsername($request->get('username'));
		if ($user == null || $user[0] == null) {
			return $this->invalidUser('not found');
		}
		$response = new Response();
		$response->setContent(json_encode([
			'username' => $user[0]->getUsername(),
			'email' => $user[0]->getEmail(),
			'pseudo' => $user[0]->getPseudo(),
			'city' => $user[0]->getCity(),
			'zipcode' => $user[0]->getZipcode(),
			'phone' => $user[0]->getPhone(),
			'bio' => $user[0]->getBio()
		]));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
		return $response;
	}

	private function invalidUser($value)
    {
        $view = $this->view(array(
		'Error' => $value), 500);

		return $this->handleView($view);
    }
}

?>