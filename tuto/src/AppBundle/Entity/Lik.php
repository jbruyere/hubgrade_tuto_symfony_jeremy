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
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Comment")
	 * @ORM\JoinColumn(nullable=true)
	*/
	private $comments;

	/**	
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Post")
	 * @ORM\JoinColumn(nullable=true)
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
     * @param \AppBundle\Entity\Post $posts
     *
     * @return Lik
     */
    public function setPosts(\AppBundle\Entity\Post $posts)
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
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
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
}
