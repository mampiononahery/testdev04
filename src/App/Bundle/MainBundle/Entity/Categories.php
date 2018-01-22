<?php

namespace App\Bundle\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="App\Bundle\MainBundle\Repository\CategoriesRepository")
 */
class Categories extends BaseEntity
{

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=180, nullable=false)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Annonces", inversedBy="categorie", cascade={"persist"})
     * @ORM\JoinTable(name="annonces_categories",
     *   joinColumns={
     *     @ORM\JoinColumn(name="categorie_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="annonce_id", referencedColumnName="id")
     *   }
     * )
     */
    private $annonce;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->annonce = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Categories
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Categories
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add annonce
     *
     * @param \App\Bundle\MainBundle\Entity\Annonces $annonce
     *
     * @return Categories
     */
    public function addAnnonce(\App\Bundle\MainBundle\Entity\Annonces $annonce)
    {
        $this->annonce[] = $annonce;

        return $this;
    }

    /**
     * Remove annonce
     *
     * @param \App\Bundle\MainBundle\Entity\Annonces $annonce
     */
    public function removeAnnonce(\App\Bundle\MainBundle\Entity\Annonces $annonce)
    {
        $this->annonce->removeElement($annonce);
    }

    /**
     * Get annonce
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }
}
