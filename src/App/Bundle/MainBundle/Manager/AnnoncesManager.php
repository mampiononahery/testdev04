<?php

namespace App\Bundle\MainBundle\Manager;

use Aes\Bundle\UserBundle\Entity\AnnoncesFavoris;
use Aes\Bundle\UserBundle\Entity\Users;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Aes\Bundle\UserBundle\Entity\Annonces;

/**
 * Class AnnoncesManager
 * @author  Fehiniaina Raharinivoson <fehiniaina28@gmail.com>
 * @package App\Bundle\MainBundle\Manager
 */
class AnnoncesManager extends BaseManager
{

    /**
     * AnnoncesManager constructor.
     *
     * @param EntityManager $em
     * @param RequestStack $requestStack
     * @param Kernel $kernel
     */
    public function __construct(EntityManager $em, RequestStack $requestStack, Kernel $kernel)
    {
        parent::__construct($em, $requestStack, $kernel) ;
    }


    /**
     * Find repository.
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        $repository = $this->em->getRepository('AppMainBundle:Annonces') ;

        return $repository ;
    }
}