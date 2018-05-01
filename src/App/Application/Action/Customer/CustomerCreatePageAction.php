<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 06/12/2017
 * Time: 14:25
 */

namespace App\Application\Action\Customer;


use App\Application\Form\CustomerForm;
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

class CustomerCreatePageAction extends CustomerAbstractAction
{


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return HtmlResponse|RedirectResponse
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        if (!$this->verifyMethod($request, ['POST'])) {
            return $this->formResponse('customer/create');
        }

        $this->rawDataForm($request);
        if (!$this->isFormValid($request)) {
            return $this->formResponse('customer/create');
        }

        /** @var Customer $customer */
        $customer = $this->getForm()->getData();
        $this->formPersiste($customer);
        $this->messageSuccess($request, self::MSG_CREATE_SUCCESS);

        return $this->redirectPost('customer.list');
    }

    /**
     * @return bool
     */
    protected function formPersiste(Customer $customer): bool
    {
        $this->getRepository()->create($customer);

        return true;
    }
}