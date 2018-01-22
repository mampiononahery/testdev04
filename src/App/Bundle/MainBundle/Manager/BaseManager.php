<?php

namespace App\Bundle\MainBundle\Manager;

use App\Bundle\MainBundle\InterfacableObject\RepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Kernel;
use App\Bundle\MainBundle\Entity\BaseEntity;

/**
 * Class BaseManager
 * @author  Fehiniaina Raharinivoson <fehiniaina28@gmail.com>
 * @package App\Bundle\MainBundle\Manager
 */
abstract class BaseManager implements RepositoryInterface
{
    /**
     * @var EntityManager $em
     */
    protected $em;

    /**
     * @var RequestStack $requestStack
     */
    protected $requestStack ;

    /**
     * @var $kernel
     */
    protected $kernel ;

    /**
     * BaseManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, RequestStack $requestStack, Kernel $kernel)
    {
        $this->em           = $em ;
        $this->requestStack = $requestStack->getCurrentRequest() ;
        $this->kernel       = $kernel ;
    }

    /**
     * save.
     * 
     * @param BaseEntity $entity
     * @throws ORMException
     */
    public function save ( BaseEntity $entity )
    {
        try {
            $this->em->persist($entity);
            $this->em->flush();
        } catch ( ORMException $e ) {
            throw $e ;
        }
    }

    /**
     * delete.
     *
     * @param  BaseEntity $entity
     * @throws ORMException
     */
    public function delete ( BaseEntity $entity )
    {
        try {
            $this->em->remove($entity);
            $this->em->flush();
        } catch ( ORMException $e ) {
            throw $e ;
        }
    }

    /**
     * write log.
     *
     * @param $_oParam
     * @param null|string $_zLog
     */
    public function write($_oParam, $_zLog = null)
    {
        if ( null !== $_zLog ) {
            file_put_contents($this->kernel->getLogDir() . $_zLog, print_r($_oParam, true), FILE_APPEND | LOCK_EX) ;
        } else {
            file_put_contents($this->kernel->getLogDir() . '/custom.log', print_r($_oParam, true), FILE_APPEND | LOCK_EX) ;
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function fetch()
    {
        return $this
            ->getRepository()
            ->findAll() ;
    }

    /**
     * @param $id
     * @return null|object
     */
    public function load($id)
    {
        return $this
            ->getRepository()
            ->findOneBy(array('id' => $id));
    }

    /**
     * Load by.
     *
     * @param  array $params
     * @return null|object
     */
    public function loadBy($params = array())
    {
        return $this
            ->getRepository()
            ->findBy($params);
    }

    /**
     * @param $select
     * @return $this
     */
    public function addSelect($select)
    {
        $qb = $this->getQueryBuilder()->addSelect($select);
        $this->setQueryBuilder($qb);

        return $this;
    }

    /**
     * @param array $options
     * @param array $filters
     * @return mixed
     */
    public function countBy($options = array(), $filters = array())
    {
        $query = $this->getRepository()->getNbQueryBuilder($options);

        return $query->getQuery()->getSingleResult() ;
    }

    /**
     * @param $options
     * @param array $filters
     * @param array $sortings
     * @return mixed
     */
    public function findByCriteria( $options, $filters = array(), $sortings = array() )
    {
        $query = $this->getRepository()->findByCriteriaQueryBuilder($options);
        $query = $this->getRepository()->addSortings($query, $sortings);

        if ($filters != null) {
            $query = $this->getRepository()->addLimit($query, $filters);
        }

        return $query->getQuery();
    }

    /**
     * @return mixed
     */
    public function getOneOrNullResult()
    {
        return $this
            ->getQueryBuilder()
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Query::HYDRATE_OBJECT
     * Query::HYDRATE_ARRAY
     * Query::HYDRATE_SCALAR
     * Query::HYDRATE_SINGLE_SCALAR
     */
    public function getSingleResult($hydrate=\Doctrine\ORM\Query::HYDRATE_OBJECT)
    {
        return $this
            ->getQueryBuilder()
            ->getQuery()
            ->getSingleResult($hydrate);
    }

    /**
     * Query::HYDRATE_OBJECT
     * Query::HYDRATE_ARRAY
     * Query::HYDRATE_SCALAR
     * Query::HYDRATE_SINGLE_SCALAR
     */
    public function getResult($hydrate=\Doctrine\ORM\Query::HYDRATE_OBJECT)
    {
        return $this
            ->getQueryBuilder()
            ->getQuery()
            ->getResult($hydrate);
    }
}