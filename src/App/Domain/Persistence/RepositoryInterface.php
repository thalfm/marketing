<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 03/12/2017
 * Time: 13:31
 */

namespace App\Domain\Persistence;


interface RepositoryInterface
{
    public function create($entity);
    public function update($entity);
    public function remove($entity);
    public function find($id);
    public function findAll();
}