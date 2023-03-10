<?php namespace App\Repositories;

use App\Models\CompanyBranch;
use App\Models\User;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Sentinel;


class CompanyBranchRepositoryEloquent extends BaseRepository implements CompanyBranchRepository
{
    private $userRepository;

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return CompanyBranch::class;
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

    public function getAll()
    {
        $companybranches = $this->model;
        return $companybranches;
    }

    public function create(array $data)
    {
        $this->generateParams();
        $user_id = $this->userRepository->getUser()->id;
        $user = $this->userRepository->find($user_id);
        $companybranches = $this->model->create($data);
        return $companybranches;
    }

    public function getAllForCompany($company_id)
    {


        $models = $this->model->where('company_id',$company_id);

        return $models;
    }


}
