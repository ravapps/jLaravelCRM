<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Traits\TransformableTrait;
use Venturecraft\Revisionable\RevisionableTrait;

class Todo extends Model
{
    use SoftDeletes,RevisionableTrait,TransformableTrait;
    protected $dates = ['deleted_at'];
    protected $guarded  = ['id'];
    protected $table = 'todos';
}
