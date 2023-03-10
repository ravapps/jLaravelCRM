<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamsWorkers extends Model
{
    //


    protected $fillable = [
        'team_id',
        'worker_emp_id',
        'created_by',
    ];




    public function team()
    {
        return $this->hasOne('App\Teams', 'id', 'team_id');
    }

    public function worker()
    {

        return $this->hasOne('App\Employee', 'id', 'worker_emp_id');
    }


}
