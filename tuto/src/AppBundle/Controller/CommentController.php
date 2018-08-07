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

class CommentController extends FOSRestController
{
	/**
	* @Rest\View(statusCode=Response::HTTP_CREATED)
	* @Rest\Post("/post/comment/create/{id}")
	* @Route("/post/comment/create/{id}")
	*/
	// at least: content, token(authorization)

	public function createCommentAction($id, Request $request)
	{
		$em = $this->get('doctrine.orm.entity_manager');
		$user = $this->getDoctrine()
			->getRepository('AppBundle:User')->getUserFromToken($request, $em);
		if ($user == null || $user[0]['id'] == null) {
			return $this->invalidComment('User not connected.');
		}
		$post = $this->getDoctrine()
			->getRepository('AppBundle:Post')->getPostFromId($id);
		if ($post == null || $user[0]['id'] == null) {
			return $this->invalidComment('You cannot comment this post.');
		}
		if ($request->get('content') == null) {
			return $this->invalidComment('You have to set a new content.');
		}
		
		$comment = new Comment();
		$comment->setUser($user[0]['id']);
		$comment->setContent($request->get('content'));
		$comment->setCreationDate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
		$comment->setLik(null);
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($comment);
		$em->flush();

		
		$post[0]->addComment($comment);
		$em = $this->getDoctrine()->getManager();
		$em->persist($post[0]);
		$em->flush();

		$data = array(
			'user' => $comment->getUser(),
			'create comment' => $comment->getContent(),
			'on post' => $post[0]->getId()
			);
		$view = $this->view($data, 200);

		return $this->handleView($view);
	}

	/**
	* @Rest\View(statusCode=Response::HTTP_CREATED)
	* @Rest\Delete("/post/comment/delete/{id}")
	* @Route("/post/comment/delete/{id}")
	*/
	// at least: token(authorization)

	public function deleteCommentAction($id, Request $request)
	{
		$em = $this->get('doctrine.orm.entity_manager');
		$user = $this->getDoctrine()
			->getRepository('AppBundle:User')->getUserFromToken($request, $em);
		if ($user == null || $user[0]['id'] == null) {
			return $this->invalidComment('User not connected.');
		}
		$comment = $this->getDoctrine()
			->getRepository('AppBundle:Comment')->getCommentFromId($id);
		if ($comment == null || $user[0]['id'] != $comment[0]->getUser()) {
			return $this->invalidComment('You cannot delete this comment.');
		}
		$this->getDoctrine()
			->getRepository('AppBundle:Comment')->deleteCommentFromId($id);
		$data = array(
			'deleted post' => $id
			);
		$view = $this->view($data, 200);

		return $this->handleView($view);
	}

	/**
	* @Rest\View(statusCode=Response::HTTP_CREATED)
	* @Rest\Get("/post/comment/read/{id}")
	* @Route("/post/comment/read/{id}")
	*/
	public function readCommentAction($id)
	{
		$em = $this->get('doctrine.orm.entity_manager');
		$comment = $this->getDoctrine()
			->getRepository('AppBundle:Comment')->getCommentFromId($id);
		if ($comment == null) {
			return $this->invalidComment('Invalid post.');
		}
		$data = array(
			'UserId' => $comment[0]->getUser(),
			'commentId' => $comment[0]->getId(),
			'content' => $comment[0]->getContent()
			);
		$view = $this->view($data, 200);

		return $this->handleView($view);
	}

	/**
	* @Rest\View(statusCode=Response::HTTP_CREATED)
	* @Rest\Put("/post/comment/update/{id}")
	* @Route("/post/comment/update/{id}")
	*/
	//at least: content, token(authorization)
	public function updateCommentAction($id, Request $request)
	{
		$em = $this->get('doctrine.orm.entity_manager');
		$user = $this->getDoctrine()
			->getRepository('AppBundle:User')->getUserFromToken($request, $em);
		if ($user == null || $user[0]['id'] == null) {
			return $this->invalidComment('User not connected.');
		}
		$comment = $this->getDoctrine()
			->getRepository('AppBundle:Comment')->getCommentFromId($id);
		if ($comment == null || $user[0]['id'] != $comment[0]->getUser()) {
			return $this->invalidComment('You cannot update this post.');
		}
		if ($request->get('content') == null) {
			return $this->invalidComment('You have to set a new content.');
		}
		$comment[0]->setContent($request->get('content'));

		$em = $this->getDoctrine()->getManager();
		$em->persist($comment[0]);
		$em->flush();
		
		$data = array(
			'userId' => $comment[0]->getUser(),
			'content (update)' => $request->get('content')
			);
		$view = $this->view($data, 200);
		return $this->handleView($view);
	}

	private function invalidComment($value)
    {
        $view = $this->view(array(
		'Error' => $value), 500);

		return $this->handleView($view);
    }
}
?>