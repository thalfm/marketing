<?php

namespace App\Application\Action\Campaign;

use App\Application\Form\CampaignForm;
use App\Domain\Entity\Campaign;
use Zend\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Router\RouterInterface;
use App\Domain\Persistence\CampaignRepositoryInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


class CampaignCreatePageAction extends CampaignAbstractAction
{


    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {

        if (!$this->verifyMethod($request, ['POST'])) {
            return $this->formResponse('campaign/create');
        }

        $this->rawDataForm($request);
        if (!$this->isFormValid($request)) {
            return $this->formResponse('campaign/create');
        }

        /** @var Campaign $campaign */
        $campaign = $this->getForm()->getData();
        $this->formPersiste($campaign);
        $this->messageSuccess($request, self::MSG_CREATE_SUCCESS);

        return $this->redirectPost('campaign.list');

    }

    /**
     * @return bool
     */
    protected function formPersiste(Campaign $campaign): bool
    {
        $this->getRepository()->create($campaign);

        return true;
    }
}
