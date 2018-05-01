<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 06/12/2017
 * Time: 14:25
 */

namespace App\Application\Action\Customer;


use App\Application\Form\CustomerForm;
use App\Application\Form\HttpMethodElement;
use App\Domain\Entity\Customer;
use App\Domain\Persistence\CustomerRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function var_dump;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CustomerUpdatePageAction extends CustomerAbstractAction
{

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return HtmlResponse|RedirectResponse
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $entity = $this->getEntityBy($request);
        $this->bindFormBy($entity, new HttpMethodElement('PUT'));

        if (!$this->verifyMethod($request, ['POST', 'PUT'])) {
            return $this->formResponse('customer/update');
        }

        $this->rawDataForm($request);
        if (!$this->isFormValid($request)) {
            return $this->formResponse('customer/update');
        }

        /** @var Customer $customer */
        $customer = $this->getForm()->getData();
        $this->formPersiste($customer);
        $this->messageSuccess($request, self::MSG_UPDATE_SUCCESS);

        return $this->redirectPost('customer.list');
    }


    /**
     * @return bool
     */
    protected function formPersiste(Customer $customer): bool
    {
        $this->getRepository()->update($customer);

        return true;
    }
}