<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 01/05/2018
 * Time: 15:22
 */

namespace App\Infrastructure\Service;


use App\Domain\Entity\Campaign;
use App\Domain\Persistence\CustomerRepositoryInterface;
use App\Domain\Service\CampaignReportInterface;
use Mailgun\Mailgun;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignReport implements CampaignReportInterface
{
    /**
     * @var Campaign
     */
    private $campaign;
    private $templateRenderer;
    private $mailGunConfig;
    private $mailgun;
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        Mailgun $mailgun,
        array $mailGunConfig,
        CustomerRepositoryInterface $customerRepository)
    {

        $this->templateRenderer = $templateRenderer;
        $this->mailGunConfig = $mailGunConfig;
        $this->mailgun = $mailgun;
        $this->customerRepository = $customerRepository;
    }

    public function setCampaign(Campaign $campaign)
    {
        $this->campaign = $campaign;
        return $this;
    }

    public function render(): ResponseInterface
    {
        $this->getCampaignData();

        return new HtmlResponse($this->templateRenderer->render('app::campaign/report', [
            'campaign_data' => $this->getCampaignData(),
            'campaign' => $this->campaign,
            'customers_count' => $this->getCountCostumers(),
            'opened_distinct_count' => $this->getCountOpenedDistinct()
        ]));
    }

    public function print(): ResponseInterface
    {
        $this->getCampaignData();

        return new HtmlResponse($this->templateRenderer->render('app::campaign/_report_detail', [
            'campaign_data' => $this->getCampaignData(),
            'campaign' => $this->campaign,
            'customers_count' => $this->getCountCostumers(),
            'opened_distinct_count' => $this->getCountOpenedDistinct()
        ]));
    }

    protected function getCampaignData()
    {
        $domain = $this->mailGunConfig['domain'];
        $response = $this->mailgun->get("{$domain}/campaigns/campaign_{$this->campaign->getId()}");

        return $response->http_respose_body;
    }

    protected function getCountOpenedDistinct()
    {
        $domain = $this->mailGunConfig['domain'];
        $response = $this->mailgun->get("{$domain}/campaigns/campaign_{$this->campaign->getId()}/opens", [
            'groupby' => 'recipient',
            'count' => true
        ]);

        return $response->http_respose_body->count;
    }

    protected function getCountCostumers()
    {
        return 10;
    }
}