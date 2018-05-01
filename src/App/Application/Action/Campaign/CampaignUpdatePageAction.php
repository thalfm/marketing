<?php

namespace App\Application\Action\Campaign;

use App\Application\Form\CampaignForm;
use App\Application\Form\HttpMethodElement;
use App\Domain\Entity\Campaign;
use App\Domain\Persistence\CampaignRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


class CampaignUpdatePageAction extends CampaignAbstractAction
{


    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $entity = $this->getEntityBy($request);
        $this->bindFormBy($entity, new HttpMethodElement('PUT'));

        if (!$this->verifyMethod($request, ['POST', 'PUT'])) {
            return $this->formResponse('campaign/update');
        }

        $this->rawDataForm($request);
        if (!$this->isFormValid($request)) {
            return $this->formResponse('campaign/update');
        }

        /** @var Campaign $campaign */
        $campaign = $this->getForm()->getData();
        $this->formPersiste($campaign);
        $this->messageSuccess($request, self::MSG_UPDATE_SUCCESS);

        return $this->redirectPost('campaign.list');

    }

    /**
     * @return bool
     */
    protected function formPersiste(Campaign $campaign): bool
    {
        $this->getRepository()->update($campaign);

        return true;
    }
}
