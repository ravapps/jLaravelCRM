<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Traits\TransformableTrait;
use Venturecraft\Revisionable\RevisionableTrait;

class Task extends Model  {
    use SoftDeletes,RevisionableTrait,TransformableTrait;
    protected $dates = ['deleted_at'];
    protected $table = 'tasks';
    protected $guarded  = ['id'];
    protected $appends = ['task_start_date','task_due_date'];

    public function date_time_format()
    {
        return config('settings.date_time_format');
    }

    public function setStartDateAttribute($starting_date)
    {
        if ($starting_date) {
            $this->attributes['start_date'] = date('Y-m-d H:i:s', strtotime($starting_date));
        } else {
            $this->attributes['start_date'] = '';
        }
    }

    public function getTaskStartDateAttribute()
    {
        if ('0000-00-00 00:00' == $this->start_date || '' == $this->start_date) {
            return '';
        } else {
            return date($this->date_time_format(), strtotime($this->start_date));
        }
    }

    public function setDueDateAttribute($ending_date)
    {
        if ($ending_date) {
            $this->attributes['due_date'] = date('Y-m-d H:i:s', strtotime($ending_date));
        } else {
            $this->attributes['due_date'] = '';
        }
    }

    public function getTaskDueDateAttribute()
    {
        if ('0000-00-00 00:00' == $this->due_date || '' == $this->due_date) {
            return '';
        } else {
            return date($this->date_time_format(), strtotime($this->due_date));
        }
    }

    public function taskAssignedTo(){
        return $this->belongsTo(User::class,'assigned_to');
    }

    public function assignedBy(){
        return $this->belongsTo(User::class,'user_id');
    }
}
