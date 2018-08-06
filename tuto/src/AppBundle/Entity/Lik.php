<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LikeRepository\LikeRepository")
 * @ORM\Table(name="`like`")
 */
 class Lik
 {
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
    */
	private $id;

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	*/
	private $user;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Comment")
	*/
	private $comments;

	/**	
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Post")
	*/
	private $posts;
 
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user.
     *
     * @param int $user
     *
     * @return Lik
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

	/**
     * Set posts.
     *
     * @param \AppBundle\Entity\Post|null $posts
     *
     * @return Lik
     */
    public function setPosts(\AppBundle\Entity\Post $posts = null)
    {
        $this->posts = $posts;

        return $this;
    }

    /**
     * Get posts.
     *
     * @return \AppBundle\Entity\Post
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Add comment.
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Lik
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment.
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        return $this->comments->removeElement($comment);
    }

    /**
     * Get comments.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set comments.
     *
     * @param \AppBundle\Entity\Comment|null $comments
     *
     * @return Lik
     */
    public function setComments(\AppBundle\Entity\Comment $comments = null)
    {
        $this->comments = $comments;

        return $this;
    }
}
