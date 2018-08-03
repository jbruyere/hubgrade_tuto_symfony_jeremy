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

class PostController extends FOSRestController
{
	/**
	* @Rest\View(statusCode=Response::HTTP_CREATED)
	* @Rest\Post("/post/create")
	* @Route("/post/create")
	*/
	// at least: content + token(authorization)
	public function createPostAction(Request $request)
	{
		if ($request->get('content') == null) {
			return $this->invalidPost('Invalid content.');
		}
		$post = new Post();
		$post->setContent($request->get('content'));
		$post->setCreationDate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));

		$em = $this->get('doctrine.orm.entity_manager');
		$user = $this->getDoctrine()
			->getRepository('AppBundle:User')->getUserFromToken($request, $em);
		if ($user == null || $user[0]['id'] == null) {
			return $this->invalidPost('User not connected.');
		}
		$post->setUser($user[0]['id']); //la requ�te met l'user dans un array d'arrays
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($post);
		$em->flush();
		
		$this->displayPosts();
		$data = array(
			'userId' => $post->getUser(),
			'content' => $request->get('content')
			);
		$view = $this->view($data, 200);

		return $this->handleView($view);
	}

	/**
	* @Rest\View(statusCode=Response::HTTP_CREATED)
	* @Rest\Post("/post/read/{id}")
	* @Route("/post/read/{id}")
	*/
	public function readPostAction($id)
	{
		$em = $this->get('doctrine.orm.entity_manager');
		$post = $this->getDoctrine()
			->getRepository('AppBundle:Post')->getPostFromId($id);
		if ($post == null) {
			return $this->invalidPost('Invalid post.');
		}
		$data = array(
			'UserId' => $post[0]->getUser(),
			'postId' => $post[0]->getId(),
			'content' => $post[0]->getContent()
			);
		$view = $this->view($data, 200);

		return $this->handleView($view);
	}

	/**
	* @Rest\View(statusCode=Response::HTTP_CREATED)
	* @Rest\Delete("/post/delete/{id}")
	* @Route("/post/delete/{id}")
	*/
	//at least: token(authorization)
	public function deletePostAction($id, Request $request)
	{
		$em = $this->get('doctrine.orm.entity_manager');
		$user = $this->getDoctrine()
			->getRepository('AppBundle:User')->getUserFromToken($request, $em);
		if ($user == null || $user[0]['id'] == null) {
			return $this->invalidPost('User not connected.');
		}
		$post = $this->getDoctrine()
			->getRepository('AppBundle:Post')->getPostFromId($id);
		if ($post == null || $user[0]['id'] != $post[0]->getUser()) {
			return $this->invalidPost('You cannot delete this post.');
		}
		$this->getDoctrine()
			->getRepository('AppBundle:Post')->deletePostFromId($id);
		$data = array(
			'deleted post' => $id
			);
		$view = $this->view($data, 200);

		return $this->handleView($view);
	}

	private function displayPosts()
	{
		$repository = $this->getDoctrine()
			->getManager()->getRepository('AppBundle:Post');
		$list = $repository->findAll();
		echo '<p>DB Posts: <br /></p>';
		foreach ($list as $us) {
			echo '<p> userId : '.$us->getUser()
			.'<br />post content : '.$us->getContent().'<br /><br /></p>';
		}
	}

	private function invalidPost($value)
    {
        $view = $this->view(array(
		'Error' => $value), 500);

		return $this->handleView($view);
    }
}
?>