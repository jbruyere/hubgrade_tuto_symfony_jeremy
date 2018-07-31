<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
*@ORM\Entity
*/

class Log
{
	/**
	* @ORM\Column(type="string")
	* @ORM\Id
	*/
	private $login;

	/**
	* @ORM\Column(type="string")
	*/
	private $password;

	/**
	* @ORM\Column(name="published", type="boolean")
	*/
	private $published = true;

    /**
     * Set login
     *
     * @param string $login
     *
     * @return Log
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Log
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Log
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }
}
