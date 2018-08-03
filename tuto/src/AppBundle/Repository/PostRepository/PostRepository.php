<?php

namespace AppBundle\Repository\PostRepository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;

class PostRepository extends EntityRepository
{
	public function getPostFromId($id, Request $request)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb->select('post')
			->from('AppBundle:Post', 'post')
			->where('post.id = :id')
			->setParameter('id', $id);

		return $qb->getQuery()->getResult();
	}
}
?>