<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Artist
 *
 * @ORM\Table(name="artist")
 * @ORM\Entity
 */
class Artist
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
     * @var int
     * @ORM\Column(name="spotify_id", type="string", length="50", nullable=true, unique=false)
     * 
     */
     private $spotify_id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=true, unique=false)
     */
    private $name;
    
      /**
     *
     * @ORM\ManyToMany(targetEntity="Entity\Genre")
     */
    private $genres;
    
    /**
     * @var int
     *
     * @ORM\Column(name="followers", type="integer", nullable=false, unique=false)
     */
    private $followers;
    
     /**
     * @var int
     *
     * @ORM\Column(name="popularity", type="integer", nullable=false, unique=false)
     */
    private $popularity;
    
    /**
     * @var string
     *
     * @ORM\Column(name="external_url", type="string", nullable=false, unique=false)
     */
    private $external_url;

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
     * Set spotifyId.
     *
     * @param int|null $spotifyId
     *
     * @return Artist
     */
    public function setSpotifyId($spotifyId = null)
    {
        $this->spotify_id = $spotifyId;

        return $this;
    }

    /**
     * Get spotifyId.
     *
     * @return int|null
     */
    public function getSpotifyId()
    {
        return $this->spotify_id;
    }

    /**
     * Set nom.
     *
     * @param string $name
     *
     * @return Artist
     */
    public function setName($nom)
    {
        $this->name = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set followers.
     *
     * @param int $followers
     *
     * @return Artist
     */
    public function setFollowers($followers)
    {
        $this->followers = $followers;

        return $this;
    }

    /**
     * Get followers.
     *
     * @return int
     */
    public function getFollowers()
    {
        return $this->followers;
    }


    /**
     * Set externalUrl.
     *
     * @param string $externalUrl
     *
     * @return Artist
     */
    public function setExternalUrl($externalUrl)
    {
        $this->external_url = $externalUrl;

        return $this;
    }

    /**
     * Get externalUrl.
     *
     * @return string
     */
    public function getExternalUrl()
    {
        return $this->external_url;
    }

    /**
     * Set popularity.
     *
     * @param int $popularity
     *
     * @return Artist
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;

        return $this;
    }

    /**
     * Get popularity.
     *
     * @return int
     */
    public function getPopularity()
    {
        return $this->popularity;
    }
    /**
     * Constructor
     */
     //automatiquement exécutée à l'instancitation de la classe 
    public function __construct()
    {
        $this->genres = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add genre.
     *
     * @param \Entity\genre $genre
     *
     * @return Artist
     */
    public function addGenre(\Entity\Genre $genre)
    {
        $this->genres[] = $genre;

        return $this;
    }

    /**
     * Remove genre.
     *
     * @param \Entity\genre $genre
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeGenre(\Entity\Genre $genre)
    {
        return $this->genres->removeElement($genre);
    }

    /**
     * Get genres.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGenres()
    {
        return $this->genres;
    }
    
    public function getArrayGenres()
    {
        $result=[];
        foreach ($this->genres as $genre){
            $result[]=$genre->getName();
        }
        return $result;
        
    }
}
