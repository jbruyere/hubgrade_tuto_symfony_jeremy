<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Entity\Like;
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

class LikeController extends FOSRestController
{
	/**
	* @Rest\View(statusCode=Response::HTTP_CREATED)
	* @Rest\Post("/post/like/create/{id}")
	* @Route("/post/like/create/{id}")
	*/
	// at least: token(authorization)
	public function createLikeAction($id, Request $request)
	{
		$em = $this->get('doctrine.orm.entity_manager');
		$user = $this->getDoctrine()
			->getRepository('AppBundle:User')->getUserFromToken($request, $em);
		if ($user == null || $user[0]['id'] == null) {
			return $this->invalidLike('User not connected.');
		}

		$post = $this->getDoctrine()
			->getRepository('AppBundle:Post')->getPostFromId($id);
		if ($post == null) {
			return $this->invalidLike('Invalid post.');
		}

		$like = new Like();
		$like->setUser($user[0]['id']);
		$like->setPosts($post[0]);
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($like);
		$em->flush();

		echo '<p> User '.$like->getUser().' like : </p>';
		$data = array(
			'postId' => $like->getPosts(),
			'from user' => $like->getUser()
			);
		$view = $this->view($data, 200);

		return $this->handleView($view);
	}

	/**
	* @Rest\View(statusCode=Response::HTTP_CREATED)
	* @Rest\Post("/post/like/delete/{id}")
	* @Route("/post/like/delete/{id}")
	*/
	// at least: token(authorization)
	public function deleteLikeAction($id, Request $request)
	{
		$em = $this->get('doctrine.orm.entity_manager');
		$user = $this->getDoctrine()
			->getRepository('AppBundle:User')->getUserFromToken($request, $em);
		if ($user == null || $user[0]['id'] == null) {
			return $this->invalidLike('User not connected.');
		}

		$post = $this->getDoctrine()
			->getRepository('AppBundle:Post')->getPostFromId($id);
		if ($post == null) {
			return $this->invalidLike('Invalid post.');
		}
		$like = $this->getDoctrine()
			->getRepository('AppBundle:Like')->getLikeFromPost($id);
		if (isset($like[0]) == false) {
			return $this->invalidLike('Like does not exit.');
		}
		$this->getDoctrine()
			->getRepository('AppBundle:Like')->deleteLikeFromPost($id);
		$data = array(
			'deleted like from id' => $id,
			'by user' => $user[0]['id']
			);
		$view = $this->view($data, 200);

		return $this->handleView($view);
	}

	private function invalidLike($value)
    {
        $view = $this->view(array(
		'Error' => $value), 500);

		return $this->handleView($view);
    }
}
?>