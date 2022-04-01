<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Top
 *
 * @ORM\Table(name="top_date")
 * @ORM\Entity
 */
class TopDate
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;
    
    /**
     * @ORM\Column(name="dt", type= "datetime", nullable=true, unique=false)
     */
    private $dt;
    
    /**
     * @ORM\Column(name="classement", type="integer", nullable=false, unique=false)
     */
     private $classement;
     
    /**
     * @ORM\ManyToOne(targetEntity="Artist")
     */
     private $artist;

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
     * Set dt.
     *
     * @param \DateTime|null $dt
     *
     * @return TopDate
     */
    public function setDt($dt = null)
    {
        $this->dt = $dt;

        return $this;
    }

    /**
     * Get dt   @.
     *
     * @return \DateTime|null
     */
    public function getDt()
    {
        return $this->dt;
    }

    /**
     * Set user.
     *
     * @param \Entity\User|null $user
     *
     * @return TopDate
     */
    public function setUser(\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set classement.
     *
     * @param int $classement
     *
     * @return TopDate
     */
    public function setClassement($classement)
    {
        $this->classement = $classement;

        return $this;
    }

    /**
     * Get classement.
     *
     * @return int
     */
    public function getClassement()
    {
        return $this->classement;
    }

    /**
     * Set artist.
     *
     * @param \Entity\Artist|null $artist
     *
     * @return TopDate
     */
    public function setArtist(\Entity\Artist $artist = null)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get artist.
     *
     * @return \Entity\Artist|null
     */
    public function getArtist()
    {
        return $this->artist;
    }
}
