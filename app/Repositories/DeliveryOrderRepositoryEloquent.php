<?php namespace App\Repositories;

use App\Models\Delivery;
use App\Models\User;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Sentinel;

class DeliveryOrderRepositoryEloquent extends BaseRepository implements DeliveryOrderRepository
{
    private $userRepository;
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Delivery::class;
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
        $deliverys = $this->model;
        return $deliverys;
    }

    public function create(array $data)
    {
        $this->generateParams();
        $user_id = $this->userRepository->getUser()->id;
        $user = $this->userRepository->find($user_id); 
        $delivery =      $this->model->create($data);
        return $delivery;
    }






}
