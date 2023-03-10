<?php
namespace App\Repositories;
use Prettus\Repository\Contracts\RepositoryInterface;

interface TodoRepository extends RepositoryInterface
{
    public function toDoForUser();
}