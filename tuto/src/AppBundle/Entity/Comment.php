<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
 class Comment 
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
	* @ORM\Column(nullable=true)
	* @ORM\ManyToMany(targetEntity="AppBundle\Entity\Like",
	cascade={"persist"})
	*/
	private $like;
     /**
     * Constructor
     */
    public function __construct()
    {
        $this->like = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Comment
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
     * @return Comment
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
     * @return Comment
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
     * Add like.
     *
     * @param \AppBundle\Entity\Like $like
     *
     * @return Comment
     */
    public function addLike(\AppBundle\Entity\Like $like)
    {
        $this->like[] = $like;

        return $this;
    }

    /**
     * Remove like.
     *
     * @param \AppBundle\Entity\Like $like
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeLike(\AppBundle\Entity\Like $like)
    {
        return $this->like->removeElement($like);
    }

    /**
     * Get like.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLike()
    {
        return $this->like;
    }
}
