<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class Delivery extends Model
{
    use SoftDeletes,RevisionableTrait;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
    protected $table = 'delivery';
    //protected $appends = ['start_date','expire_date'];

    public function date_format()
    {
        return config('settings.date_format');
    }

    public function setDeliveryDateAttribute($date)
    {
        $this->attributes['delivery_date'] = Carbon::createFromFormat($this->date_format(),$date)->format('Y-m-d');
    }



    public function setExpDateAttribute($exp_date)
    {
        $this->attributes['delivery_done_date'] = Carbon::createFromFormat($this->date_format(),$exp_date)->format('Y-m-d');
    }

    public function getExpireDateAttribute()
    {
        if ('0000-00-00' == $this->exp_date || '' == $this->exp_date) {
            return '';
        } else {
            return date($this->date_format(), strtotime($this->exp_date));
        }
    }

    public function salesOrder()
    {
        return $this->belongsToMany(Saleorder::class, 'salejob_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }






}
