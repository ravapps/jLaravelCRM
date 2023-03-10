<?php

namespace App\Repositories;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Prettus\Repository\Contracts\RepositoryInterface;


interface CustomerRepository extends RepositoryInterface
{
    public function getUser($customer);

    public function uploadAvatar(UploadedFile $file);
    public function getCustomerContact($id);
    public function getCustomerDetails($id);
}
