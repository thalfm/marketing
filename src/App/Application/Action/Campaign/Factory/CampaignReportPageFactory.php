<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 01/05/2018
 * Time: 15:36
 */

namespace App\Application\Action\Campaign\Factory;


use App\Application\Action\Campaign\CampaignReportPageAction;
use App\Domain\Persistence\CampaignRepositoryInterface;
use App\Domain\Service\CampaignReportInterface;
use Interop\Container\ContainerInterface;

class CampaignReportPageFactory
{
    public function __invoke(ContainerInterface $container) :CampaignReportPageAction
    {
        $repository = $container->get(CampaignRepositoryInterface::class);
        $report = $container->get(CampaignReportInterface::class);

        return new CampaignReportPageAction($repository,$report);
    }
}