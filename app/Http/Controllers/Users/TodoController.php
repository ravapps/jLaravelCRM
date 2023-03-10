<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\UserController;
use App\Repositories\OptionRepository;
use App\Repositories\TodoRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class TodoController extends UserController
{
    private $userRepository;
    private $todoRepository;
    private $optionRepository;

    public function __construct(
        UserRepository $userRepository,
        TodoRepository $todoRepository,
        OptionRepository $optionRepository
    ) {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->todoRepository = $todoRepository;
        $this->optionRepository = $optionRepository;

        view()->share('type', 'todo');
    }

    public function index()
    {
        $title = trans('todo.todo');
        $todoNew = $this->todoRepository->toDoForUser()->where('completed',0);
        $todoCompleted = $this->todoRepository->toDoForUser()->where('completed',1);
        return view('user.todo.index',compact('title','todoNew','todoCompleted'));
    }

    public function store(Request $request)
    {
        $user = $this->userRepository->getUser();
        $request->merge(['user_id'=>$user->id]);
        $this->todoRepository->create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $todo)
    {
        $todo = $this->todoRepository->find($todo);
        $todo->update($request->all());
        echo '<div class="alert alert-success">' . trans('todo.updated_successfully') . '</div>';
    }

    public function delete($todo)
    {
        $todo = $this->todoRepository->find($todo);
        $todo->delete();
        return redirect()->back();
    }

    public function isCompleted(Request $request, $todo){
        $todo = $this->todoRepository->find($todo);
        if ($request->completed==1){
            $todo->completed_at = now();
        }else{
            $todo->completed_at = null;
        }
        $todo->completed = $request->completed;
        $todo->save();
        echo '<div class="alert alert-success">' . trans('todo.status_changed') . '</div>';
    }
}
