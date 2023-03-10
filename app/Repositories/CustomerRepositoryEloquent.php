<?php

namespace App\Repositories;

use App\Models\Customer;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\DB;

class CustomerRepositoryEloquent extends BaseRepository implements CustomerRepository
{
    private $userRepository;

    private $organizationRepository;
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Customer::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function generateParams(){
        $this->userRepository = new UserRepositoryEloquent(app());
    }

    public function getUser($customer)
    {
        $this->generateParams();
        $customers = $this->with('user')->find($customer);
        return $customers;
    }
    public function getCustomerContact($id)
    {
        $custs = DB::select(DB::raw("select customers.id as id, concat(users.first_name,' ',users.last_name) as name from customers, users where customers.user_id = users.id and customers.deleted_at IS NULL and customers.company_id = ".$id));
        return collect($custs);
    }

    public function getCustomerDetails($id)
    {
        $custs = DB::select(DB::raw("select customers.mobile as mobile, users.phone_number as phone, users.email as email  from customers, users where customers.user_id = users.id and customers.deleted_at IS NULL  and customers.id = ".$id));
        return collect($custs);
    }

    public function uploadAvatar(UploadedFile $file)
    {
        $destinationPath = public_path().'/uploads/company/';
        $extension = $file->getClientOriginalExtension() ?: 'png';
        $fileName = str_random(10).'.'.$extension;

        return $file->move($destinationPath, $fileName);
    }
}
