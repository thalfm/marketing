<?php

namespace App\Application\Action\Tag;

use App\Application\Form\TagForm;
use App\Domain\Persistence\TagRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


class TagCreatePageAction
{
    private $template;
    /**
     * @var TagRepositoryInterface
     */
    private $repository;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var tagForm
     */
    private $form;


    public function __construct(
        TagRepositoryInterface $repository,
        TemplateRendererInterface $template,
        RouterInterface $router,
        TagForm $form
    ){
        $this->template = $template;
        $this->repository = $repository;
        $this->router = $router;
        $this->form = $form;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {

        if($request->getMethod() == 'POST'){
            $dataRaw = $request->getParsedBody();
            $this->form->setData($dataRaw);
            if($this->form->isValid()){
                $entity = $this->form->getData();
                $this->repository->create($entity);
                /** @var FlashMessagesInterface $flashMessage */
                $flashMessage = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
                $flashMessage->flash('success','Tag cadastrada com sucesso');
                $uri = $this->router->generateUri('tag.list');
                return new RedirectResponse($uri);
            }
        }
        return new HtmlResponse($this->template->render("app::tag/create",[
            'form' => $this->form
        ]));

    }
}
