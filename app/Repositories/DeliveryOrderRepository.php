<?php namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

interface DeliveryOrderRepository extends RepositoryInterface
{
    public function getAll();



    public function create(array $data);
}
