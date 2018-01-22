<?php

namespace App\Bundle\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Bundle\MainBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    const ROLE_OPERATOR = 'ROLE_CUSTOMER' ;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Annonces", mappedBy="user")
     */
    private $annonce;


    /**
     * Add annonce
     *
     * @param \App\Bundle\MainBundle\Entity\Annonces $annonce
     *
     * @return User
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
