<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 04/02/2018
 * Time: 13:19
 */

namespace App\Infrastructure\Persistence\Doctrine\DataFixture;


use App\Domain\Entity\Customer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CustomerFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //$faker = Faker::create();
        foreach ($this->getData() as $key => $value){
            $customer = new Customer();
            $customer
                ->setName($value['name'])
                ->setEmail($value['email']);

            $manager->persist($customer);
            $this->addReference("customer-$key",$customer);
        }

        $manager->flush();
    }

    public function getData()
    {
        return [
            ['name' => 'Thales 1', 'email' => 'teste@gmail.com'],
            ['name' => 'Thales 2', 'email' => 'teste2@gmail.com']
        ];
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 100;
    }
}