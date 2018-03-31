<?php

namespace App\Application\Action\Campaign;

use Mailgun\Mailgun;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Template;
use App\Domain\Persistence\CampaignRepositoryInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignListPageAction
{
    private $template;
    /**
     * @var CampaignRepositoryInterface
     */
    private $repository;

    public function __construct(
        CampaignRepositoryInterface $repository,
        Template\TemplateRendererInterface $template , Mailgun $emailGun)
    {
        $this->template = $template;
        $this->repository = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $campaigns = $this->repository->findAll();
        $flash = $request->getAttribute('flash');
        $flashMessage = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
        $message = $flashMessage->getFlash('success');
        return new HtmlResponse($this->template->render("app::campaign/list",[
            'campaigns'=> $campaigns,
            'message'=> $message
        ]));

    }
}
