<?php
//declare(strict_types=1);
namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Campaign
{
    private $id;
    private $name;
    private $subject;
    private $template;
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate(string $template)
    {
        $this->template = $template;
        return $this;
    }

    public function getTags() //: Collection
    {
        return $this->tags;
    }

    public function addTags(Collection $tags)
    {
        /** @var Tag $tag */
        foreach ($tags as $tag){
            $tag->getCampaigns()->add($this);
            $this->tags->add($tag);
        }
        return $this;
    }

    public function removeTags(Collection $tags)
    {
        /** @var Tag $tag */
        foreach ($tags as $tag){
            $tag->getCampaigns()->removeElement($this);
            $this->tags->removeElement($tag);
        }
        return $this;
    }

}