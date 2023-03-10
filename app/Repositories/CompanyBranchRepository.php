<?php namespace App\Repositories;


use Prettus\Repository\Contracts\RepositoryInterface;


interface CompanyBranchRepository extends RepositoryInterface
{
    public function getAll();

    public function create(array $data);

    public function getAllForCompany($company_id);
}
