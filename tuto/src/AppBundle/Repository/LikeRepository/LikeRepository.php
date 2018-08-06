<?php

namespace AppBundle\Repository\LikeRepository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Post;
use AppBundle\Entity\Like;

class LikeRepository extends EntityRepository
{
	public function getLikeFromPost($id)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb->select('\'like\'')
			->from('AppBundle:Like', 'lik')
			->where('lik.posts = :id')
			->setParameter('id', $id);

		return $qb->getQuery()->getResult();
	}

	public function deleteLikeFromPost($id)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb->delete()
			->from('AppBundle:Like', 'lik')
			->where('lik.posts = :id')
			->setParameter('id', $id);

		return $qb->getQuery()->getResult();
	}
}
?>