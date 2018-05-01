<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 01/05/2018
 * Time: 16:35
 */

namespace App\Application\Action\Campaign;


use App\Domain\Persistence\CampaignRepositoryInterface;
use App\Domain\Service\CampaignReportInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CampaignPrintPageAction
{
    /**
     * @var CampaignReportInterface
     */
    private $report;
    /**
     * @var CampaignRepositoryInterface
     */
    private $repository;

    public function __construct(
        CampaignRepositoryInterface $repository,
        CampaignReportInterface $report)
    {
        $this->report = $report;
        $this->repository = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute('id');
        $entity = $this->repository->find($id);
        $this->report->setCampaign($entity);

        return $this->report->print();
    }
}