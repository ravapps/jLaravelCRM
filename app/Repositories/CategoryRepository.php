<?php namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

interface CategoryRepository extends RepositoryInterface
{
    public function getAll();

    public function create(array $data);
}