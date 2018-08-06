<?php

namespace AppBundle\Repository\CommentRepository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Post;
use AppBundle\Entity\Like;
use AppBundle\Entity\Comment;

class CommentRepository extends EntityRepository
{
	public function getCommentFromId($id)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb->select('comment')
			->from('AppBundle:Comment', 'comment')
			->where('comment.id = :id')
			->setParameter('id', $id);

		return $qb->getQuery()->getResult();
	}

	public function deleteCommentFromId($id)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb->delete()
			->from('AppBundle:Comment', 'comment')
			->where('comment.id = :id')
			->setParameter('id', $id);

		return $qb->getQuery()->getResult();
	}
}
?>