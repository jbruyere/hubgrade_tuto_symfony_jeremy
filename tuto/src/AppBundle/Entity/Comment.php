<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository\CommentRepository")
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
	* @ORM\OneToMany(targetEntity="AppBundle\Entity\Lik",
	mappedBy="comment")
	*/
	private $lik;

     /**
     * Constructor
     */
    public function __construct()
    {
        $this->lik = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add lik.
     *
     * @param \AppBundle\Entity\Lik $lik
     *
     * @return Comment
     */
    public function addLik(\AppBundle\Entity\Lik $lik)
    {
        $this->lik[] = $lik;

        return $this;
    }

    /**
     * Remove lik.
     *
     * @param \AppBundle\Entity\Lik $lik
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeLik(\AppBundle\Entity\Lik $lik)
    {
        return $this->lik->removeElement($lik);
    }

    /**
     * Get lik.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLik()
    {
        return $this->lik;
    }

    /**
     * Set lik.
     *
     * @param string|null $lik
     *
     * @return Comment
     */
    public function setLik($lik = null)
    {
        $this->lik = $lik;

        return $this;
    }
}
