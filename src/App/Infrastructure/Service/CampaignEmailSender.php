<?php

namespace App\Infrastructure\Service;

use App\Domain\Entity\Campaign;
use App\Domain\Service\CampaignEmailSenderInterface;
use Mailgun\Mailgun;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignEmailSender implements CampaignEmailSenderInterface
{
    private $campaign;
    private $templateRenderer;
    private $mailGunConfig;
    private $mailgun;

    public function __construct(TemplateRendererInterface $templateRenderer, Mailgun $mailgun, array $mailGunConfig)
    {

        $this->templateRenderer = $templateRenderer;
        $this->mailGunConfig = $mailGunConfig;
        $this->mailgun = $mailgun;
    }


    public function setCampaign(Campaign $campaign)
    {
        $this->campaign = $campaign;
        return $this;
    }

    public function send()
    {
        $tags = $this->campaign->getTags()->toArray();
        $batchMessage = $this->getBatchMessage();
        foreach ($tags as $tag){
            $batchMessage->addTag($tag->getName());
            $customers = $tag->getCustomers()->toArray();
            foreach ($customers as $customer){
                $name = (!$customer->getName() or $customer->getName() == '')? $customer->getEmail(): $customer->getName();
                $batchMessage->addToRecipient($customer->getEmail(), ['full_name' => $customer->getName()]);
            }
        }
        $batchMessage->finalize();
    }

    protected  function getBatchMessage()
    {
        $batchMessage = $this->mailgun->BatchMessage($this->mailGunConfig['domain']);
        $batchMessage->addCampaignId("campaign_{$this->campaign->getId()}");//permite no max 3 campanhas
        $batchMessage->setFromAddress('rogeriodesouzaantonio@gmail.com', ['full_name' => 'Rsa']);
        $batchMessage->setSubject($this->campaign->getSubject());
        $batchMessage->setHtmlBody($this->getHtmlBody());
        //$batchMessage->setTextBody('string'); //só para textos
        return $batchMessage;
    }

    protected function getHtmlBody()
    {
        $template = $this->campaign->getTemplate();
        return $this->templateRenderer->render('app::campaign/_campaign_template',[
            'content' => $template
        ]);
    }
}