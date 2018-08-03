<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository\PostRepository")
 * @ORM\Table(name="post")
 */

 class Post
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
	* @ORM\Column(type="text")
	*/
	private $content;

	/**
	* @ORM\Column(type="datetime")
	*/
	private $creationDate;

	/**
	* @ORM\Column(type="datetime", nullable=true)
	*/
	private $editionDate;

	/**
	* @ORM\Column(nullable=true)
	* @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment",
	mappedBy="post")
	*/
	private $comments;
	
	/**
	* @ORM\Column(nullable=true)
	* @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment",
	mappedBy="post")
	*/
	private $likes;
     /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->likes = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Post
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
     * Set content.
     *
     * @param string $content
     *
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return Post
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate.
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set editionDate.
     *
     * @param \DateTime $editionDate
     *
     * @return Post
     */
    public function setEditionDate($editionDate)
    {
        $this->editionDate = $editionDate;

        return $this;
    }

    /**
     * Get editionDate.
     *
     * @return \DateTime
     */
    public function getEditionDate()
    {
        return $this->editionDate;
    }

    /**
     * Add comment.
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Post
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
     * Add like.
     *
     * @param \AppBundle\Entity\Comment $like
     *
     * @return Post
     */
    public function addLike(\AppBundle\Entity\Comment $like)
    {
        $this->likes[] = $like;

        return $this;
    }

    /**
     * Remove like.
     *
     * @param \AppBundle\Entity\Comment $like
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeLike(\AppBundle\Entity\Comment $like)
    {
        return $this->likes->removeElement($like);
    }

    /**
     * Get likes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikes()
    {
        return $this->likes;
    }
}
