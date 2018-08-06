<?php

namespace AppBundle\Repository\LikeRepository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Post;
use AppBundle\Entity\Lik;

class LikeRepository extends EntityRepository
{
	public function getLikeFromPost($id)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb->select('lik')
			->from('AppBundle:Lik', 'lik')
			->where('lik.posts = :id')
			->setParameter('id', $id);

		return $qb->getQuery()->getResult();
	}

	public function deleteLikeFromPost($id)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb->delete()
			->from('AppBundle:Lik', 'lik')
			->where('lik.posts = :id')
			->setParameter('id', $id);

		return $qb->getQuery()->getResult();
	}

	public function getLikeFromComment($id)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb->select('lik')
			->from('AppBundle:Lik', 'lik')
			->where('lik.comments = :id')
			->setParameter('id', $id);

		return $qb->getQuery()->getResult();
	}

	public function deleteLikeFromComment($id)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb->delete()
			->from('AppBundle:Lik', 'lik')
			->where('lik.comments = :id')
			->setParameter('id', $id);

		return $qb->getQuery()->getResult();
	}
}
?>