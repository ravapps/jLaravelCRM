<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    //


    protected $fillable = [
        'supervisor_emp_id',
        'team_name',
        'created_by',
    ];




    public static function team_id()
    {
        $team = Teams::latest()->first();

        return !empty($team) ? $team->id + 1 : 1;
    }


    public function supervisor()
    {
        return $this->hasOne('App\Employee', 'id', 'supervisor_emp_id');
    }

    public function workers()
    {
      return $this->hasMany('App\TeamsWorkers','team_id','id');
    }


}
