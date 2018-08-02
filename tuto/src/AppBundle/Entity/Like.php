<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="like")
 */
 class Like
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

	private $comments;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Post")
	 * @ORM\JoinColumn(nullable=false)
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
     * @return Like
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
     * @return Like
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
}
