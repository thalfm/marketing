<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 12/02/2018
 * Time: 20:18
 */

namespace App\Infrastructure\Service;


use App\Domain\Service\AuthInterface;
use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use Zend\Authentication\AuthenticationService;

class AuthService implements AuthInterface
{
    private $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function authenticate($email, $password)
    {
        /** @var ValidatableAdapterInterface $adapter */
        $adapter = $this->authenticationService->getAdapter();
        $adapter->setIdentity($email);
        $adapter->setCredential($password);
        $result = $this->authenticationService->authenticate();
        return $result->isValid();
    }

    public function isAuth()
    {
        return $this->getUser() != null;
    }

    public function getUser()
    {
        return $this->authenticationService->getIdentity();
    }

    public function destroy()
    {
        $this->authenticationService->clearIdentity();
    }
}