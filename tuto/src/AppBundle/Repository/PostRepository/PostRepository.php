<?php

namespace AppBundle\Repository\PostRepository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Post;

class PostRepository extends EntityRepository
{
	public function getPostFromId($id)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb->select('post')
			->from('AppBundle:Post', 'post')
			->where('post.id = :id')
			->setParameter('id', $id);
		
		return $qb->getQuery()->getResult();
	}

	public function findPost()
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb->select('post')->from('AppBundle:Post', 'post');

		return $qb->getQuery()->getResult();
	}

	public function deletePostFromId($id)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb->delete()
			->from('AppBundle:Post', 'post')
			->where('post.id = :id')
			->setParameter('id', $id);

		return $qb->getQuery()->getResult();
	}
}
?>