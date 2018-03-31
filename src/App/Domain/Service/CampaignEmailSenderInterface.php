<?php

namespace App\Domain\Service;

use App\Domain\Entity\Campaign;

interface CampaignEmailSenderInterface extends EmailServiceInterface
{
    public function setCampaign(Campaign $campaign);
}