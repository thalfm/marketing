<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 03/12/2017
 * Time: 14:16
 */

namespace App\Infrastructure\Persistence\Doctrine\Repository;


use App\Domain\Entity\Customer;
use App\Domain\Entity\User;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

/**
 * Class CustomerRepositoryFactory
 * @package App\Infrastructure\Persistence\Doctrine\Repository
 */
class UserRepositoryFactory
{
    /**
     * @param ContainerInterface $container
     * @return \Doctrine\ORM\EntityRepository
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityManager $entityManeger */
        $entityManager = $container->get(EntityManager::class);
        return $entityManager->getRepository(User::class);
    }
}