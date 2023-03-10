<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeductionOption extends Model
{
    protected $fillable = [
        'name',
        'deduct_amt' ,
        'created_by',
    ];
}
