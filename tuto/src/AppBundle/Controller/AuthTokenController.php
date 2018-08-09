<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Form\CredentialsType;
use AppBundle\Entity\AuthToken;
use AppBundle\Entity\Credentials;
use FOS\RestBundle\Controller\FOSRestController;

class AuthTokenController extends FOSRestController
{
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"auth-token"})
     * @Rest\Post("/login")
	 * @Route("/login", name="user_tokens")
     */
	 // at least: username, password
    public function postAuthTokensAction(Request $request)
    {
		$credentials = new Credentials();
        $form = $this->createForm(CredentialsType::class, $credentials);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $this->invalidCredentials('Invalid credentials');
        }

        $em = $this->get('doctrine.orm.entity_manager');

        $user = $em->getRepository('AppBundle:User')
            ->findOneByUsername($credentials->getUsername());
		
        if (!$user) {
            return $this->invalidCredentials('Invalid user');
        }
        $encoder = $this->get('security.password_encoder');
        $isPasswordValid = $encoder->isPasswordValid($user, $credentials->getPassword());

        if (!$isPasswordValid) {
            return $this->invalidCredentials('Invalid password');
        }

        $authToken = new AuthToken();
        $authToken->setValue(base64_encode(random_bytes(50)));
        $authToken->setCreatedAt(new \DateTime('now'));
        $authToken->setUser($user);

        $em->persist($authToken);
        $em->flush();
		$repository = $this->getDoctrine()
			->getManager()->getRepository('AppBundle:AuthToken');
		$list = $repository->findAll();

		/*echo '<p>DB : <br /></p>';
		foreach ($list as $us) {
			echo '<p> username : '
			.$us->getUser()->getUsername().' token :'.$us->getValue().'</p>';
		}

		echo 'connected : ';*/
        /*$view = $this->view(
		array(
		'username' => $request->get('username'),
		'token' => $authToken->getValue()
		), 200);

		return $this->handleView($view);*/
		$response = new Response();
		$response->setContent(json_encode([
			'username' => $request->get('username'),
			'token' => $authToken->getValue()
		]));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
		return $response;
    }

    private function invalidCredentials($value)
    {
        $view = $this->view(array(
		'message' => $value), 500);

		return $this->handleView($view);
    }
}