<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class Customer extends Model
{
    use SoftDeletes, RevisionableTrait;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
    protected $table = 'customers';
    protected $fillable = ['mobile', 'is_main_contact', 'fax', 'website', 'title', 'address','company_id','sales_team_id','first_name','last_name','email','job_position','company_avatar','phone_number'];

	protected $appends = ['avatar'];

  public static function boot() {
      parent::boot();

      static::deleting(function($customer) { // before delete() method call this
           $customer->user()->delete();
           $customer->leads()->delete();
           $customer->calls()->delete();
           $customer->quotations()->delete();
           // do the rest of the cleanup...
      });
  }



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'belong_user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function salesTeam()
    {
        return $this->belongsTo(Salesteam::class);
    }

    public function contactSitelocation()
    {
        return $this->belongsTo(CompanyBranch::class, 'address');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class,'customer_id');
    }

    public function calls()
    {
        return $this->hasMany(Call::class,'customer_id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class,'customer_id');
    }

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class,'customer_id');
    }

	public function getAvatarAttribute() {
		$val = $this->user->attributes['user_avatar'];
		if (strlen($val) > 1) {
			$val = asset( 'uploads/avatar' ) . '/' . $val;
		}
		return $val;
	}

}
