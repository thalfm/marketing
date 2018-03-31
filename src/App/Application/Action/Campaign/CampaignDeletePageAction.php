<?php

namespace App\Application\Action\Campaign;

use App\Application\Form\CampaignForm;
use Zend\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Router\RouterInterface;
use App\Domain\Persistence\CampaignRepositoryInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Application\Form\HttpMethodElement;


class CampaignDeletePageAction
{
    private $template;
    /**
     * @var CampaignRepositoryInterface
     */
    private $repository;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var CampaignForm
     */
    private $form;


    public function __construct(
        CampaignRepositoryInterface $repository,
        TemplateRendererInterface $template,
        RouterInterface $router,
        CampaignForm $form
    ){
        $this->template = $template;
        $this->repository = $repository;
        $this->router = $router;
        $this->form = $form;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute('id');
        $entity = $this->repository->find($id);
        $this->form->add(new HttpMethodElement('DELETE'));
        $this->form->bind($entity);
        if($request->getMethod() == 'DELETE'){
            $this->repository->remove($entity);
            /** @var FlashMessagesInterface $flashMessage */
            $flashMessage = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
            $flashMessage->flash('success','Campanha deletada com sucesso');
            $uri = $this->router->generateUri('campaign.list');
            return new RedirectResponse($uri);
        }
        return new HtmlResponse($this->template->render("app::campaign/delete",[
            'form' => $this->form
        ]));

    }
}
