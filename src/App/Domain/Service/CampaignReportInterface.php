<?php

namespace App\Domain\Service;

use App\Domain\Entity\Campaign;
use Psr\Http\Message\ResponseInterface;

interface CampaignReportInterface
{
    public function setCampaign(Campaign $campaign);

    public function render(): ResponseInterface;

    public function print(): ResponseInterface;
}