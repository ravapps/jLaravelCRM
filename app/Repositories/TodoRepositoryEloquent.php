<?php

namespace App\Repositories;

use App\Models\Todo;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class TodoRepositoryEloquent extends BaseRepository implements TodoRepository
{
    private $userRepository;
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Todo::class;
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

    public function toDoForUser()
    {
        $this->generateParams();
        $user = $this->userRepository->getUser();
        return $this->model->latest()->get()->where('user_id',$user->id);
    }
}
