<?php

namespace App\Application\Action\Campaign;

use App\Application\Form\CampaignForm;
use App\Application\Form\HttpMethodElement;
use App\Domain\Persistence\CampaignRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


class CampaignUpdatePageAction
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
        $this->form->add(new HttpMethodElement('PUT'));
        $this->form->bind($entity);
        if($request->getMethod() == 'PUT'){
            $flash = $request->getAttribute('flash');
            $dataRaw = $request->getParsedBody();
            $this->form->setData($dataRaw);
            if($this->form->isValid()){
                $entity = $this->form->getData();
                $this->repository->update($entity);
                /** @var FlashMessagesInterface $flashMessage */
                $flashMessage = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
                $flashMessage->flash('success','Campanha atualizada com sucesso');
                $uri = $this->router->generateUri('campaign.list');
                return new RedirectResponse($uri);
            }
        }
        return new HtmlResponse($this->template->render("app::campaign/update",[
            'form' => $this->form
        ]));

    }
}
