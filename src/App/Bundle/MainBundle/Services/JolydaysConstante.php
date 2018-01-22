<?php
namespace App\Bundle\MainBundle\Services;


abstract class JolydaysConstante
{
    /**
     * Status d'une annonce actif.
     *
     * @var integer
     */
    const ANNONCE_STATUS_ACTIF = 1 ;

    public static $RENT_NUMBER = array (
        'Non' => '0',
        'Oui' => '1',
    ) ;
}