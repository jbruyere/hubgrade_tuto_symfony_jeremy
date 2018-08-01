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
     * @Rest\Post("/auth-tokens")
	 * @Route("/auth-tokens", name="user_tokens")
     */
    public function postAuthTokensAction(Request $request)
    {
        $credentials = new Credentials();
        $form = $this->createForm(CredentialsType::class, $credentials);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $this->invalidCredentials();
        }

        $em = $this->get('doctrine.orm.entity_manager');

        $user = $em->getRepository('AppBundle:User')
            ->findOneByEmail($credentials->getLogin());
		
        if (!$user) {
            return $this->invalidCredentials();
        }

        $encoder = $this->get('security.password_encoder');
        $isPasswordValid = $encoder->isPasswordValid($user, $credentials->getPassword());

        if (!$isPasswordValid) {
            return $this->invalidCredentials();
        }

        $authToken = new AuthToken();
        $authToken->setValue(base64_encode(random_bytes(50)));
        $authToken->setCreatedAt(new \DateTime('now'));
        $authToken->setUser($user);

        $em->persist($authToken);
        $em->flush();

        $view = $this->view(array(
		'username' => $request->get('username'), 200);

		return $this->handleView($view);
    }

    private function invalidCredentials()
    {
        $view = $this->view(array(
		'message' => 'invalid credentials.'), 500);

		return $this->handleView($view);
    }
}