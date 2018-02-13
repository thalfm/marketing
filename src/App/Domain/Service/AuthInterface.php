<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 12/02/2018
 * Time: 20:15
 */

namespace App\Domain\Service;


use App\Domain\Entity\User;

interface AuthInterface
{
    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    public function authenticate($email, $password);

    /**
     * @return bool
     */
    public function isAuth();

    /**
     * @return User
     */
    public function getUser();

    /**
     * @return bool
     */
    public function destroy();
}