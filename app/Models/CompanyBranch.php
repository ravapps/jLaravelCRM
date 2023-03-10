<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class CompanyBranch extends Model
{
    use SoftDeletes,RevisionableTrait;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
    protected $table = 'companybranches';

    public function getBranchSelectAttribute()
    {
      return $this->sitelocation. '('.$this->postalcode.') '.$this->street;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
