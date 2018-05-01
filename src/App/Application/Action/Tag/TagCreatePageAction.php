<?php

namespace App\Application\Action\Tag;

use App\Application\Form\TagForm;
use App\Domain\Entity\Tag;
use App\Domain\Persistence\TagRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


class TagCreatePageAction extends TagAbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        if (!$this->verifyMethod($request, ['POST'])) {
            return $this->formResponse('tag/create');
        }

        $this->rawDataForm($request);
        if (!$this->isFormValid($request)) {
            return $this->formResponse('tag/create');
        }

        /** @var Tag $tag */
        $tag = $this->getForm()->getData();
        $this->formPersiste($tag);
        $this->messageSuccess($request, self::MSG_CREATE_SUCCESS);

        return $this->redirectPost('tag.list');

    }

    /**
     * @return bool
     */
    protected function formPersiste(Tag $tag): bool
    {
        $this->getRepository()->create($tag);

        return true;
    }
}
