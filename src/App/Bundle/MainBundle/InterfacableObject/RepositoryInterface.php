<?php

namespace App\Bundle\MainBundle\InterfacableObject;


/**
 * interface RepositoryInterface
 * @author  Fehiniaina Raharinivoson <fehiniaina28@gmail.com>
 * @package App\Bundle\MainBundle\InterfacableObject
 */
interface RepositoryInterface
{
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository() ;
}