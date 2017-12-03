<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 03/12/2017
 * Time: 13:51
 */

namespace App\Infrastructure\Persistence\Doctrine\Repository;


use App\Domain\Persistence\CustomerRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\UnitOfWork;

class CustomerRepository extends EntityRepository implements CustomerRepositoryInterface
{

    public function create($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }
    public function update($entity)
    {
        if($this->getEntityManager()->getUnitOfWork()->getEntityState($entity) != UnitOfWork::STATE_MANAGED) {
            $this->getEntityManager()->merge($entity);
        }
        $this->getEntityManager()->flush();
        return $entity;
    }
    public function remove($entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
    public function find($id)
    {
        return parent::find($id);
    }
    public function findAll(){
        return parent::findAll();
    }
}