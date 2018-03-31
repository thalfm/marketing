<?php
declare(strict_types=1);
namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Tag
{
    private $id;
    private $name;
    private $customers;
    private $campaigns;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
        $this->campaigns = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getCustomers() : Collection
    {
        return $this->customers;
    }

    public function getCampaigns() : Collection
    {
        return $this->campaigns;
    }
}
