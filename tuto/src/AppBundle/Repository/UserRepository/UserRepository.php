<?php

namespace AppBundle\Repository\UserRepository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\AuthToken;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserRepository extends EntityRepository
{
	public function getUserFromToken(Request $request, $em)
	{

		$user = new User();
		$token = new AuthToken();
		$tokenvalue = $request->headers->get('Authorization');
		
		//marche mas n'utilise pas de requête sql :
		/*$token = $em->getRepository('AppBundle:AuthToken')
			->findOneByValue($tokenvalue);
		$id = $token->getUser()->getId();
		$user = $em->getRepository('AppBundle:User')
            ->findOneById($id);*/

		$user = $this->findUserByToken($tokenvalue);
		return $user;
	}

	public function findUserByToken($tokenvalue)
	{
	$qb = $this->getEntityManager()->createQueryBuilder();

	$qb->select('u.id')
		->from('AppBundle:AuthToken', 'auth')
		->leftJoin('auth.user', 'u')
		->where('auth.value = :tokenvalue')
		->setParameter('tokenvalue', substr($tokenvalue, 7));

	return $qb->getQuery()->getResult();
	}
}
?>