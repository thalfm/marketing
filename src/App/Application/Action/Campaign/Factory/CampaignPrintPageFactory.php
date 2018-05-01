<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 01/05/2018
 * Time: 16:38
 */

namespace App\Application\Action\Campaign\Factory;

use App\Application\Action\Campaign\CampaignPrintPageAction;
use App\Domain\Persistence\CampaignRepositoryInterface;
use App\Domain\Service\CampaignReportInterface;
use Interop\Container\ContainerInterface;

class CampaignPrintPageFactory
{
    public function __invoke(ContainerInterface $container) :CampaignPrintPageAction
    {
        $repository = $container->get(CampaignRepositoryInterface::class);
        $report = $container->get(CampaignReportInterface::class);

        return new CampaignPrintPageAction($repository,$report);
    }
}