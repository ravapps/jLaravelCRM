<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class Company extends Model
{
    use SoftDeletes,RevisionableTrait;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
    protected $table = 'companies';

	protected $appends = ['avatar'];



  public static function boot() {
      parent::boot();

      static::deleting(function($company) { // before delete() method call this
           $company->companybranches()->delete();
           //$company->customerCompany()->user()->delete();
           foreach($company->customerCompany() as $ite) {
             $ite->user()->delete();
           }
           $company->leads()->delete();
           $company->calls()->delete();
           $company->customerCompany()->delete();



           //$customer->leads()->delete();
           //$customer->calls()->delete();
           // do the rest of the cleanup...
      });
  }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contactPerson()
    {
        return $this->belongsTo(User::class,'main_contact_person');
    }

    public function salesTeam()
    {
        return $this->belongsTo(Salesteam::class, 'sales_team_id');
    }


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function companybranches()
    {
        return $this->hasMany(CompanyBranch::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function customerCompany()
    {
        return $this->hasMany(Customer::class, 'company_id');
    }
    public function leads()
    {
        return $this->hasMany(Lead::class,'company_id');
    }

    public function calls()
    {
        return $this->hasMany(Call::class,'company_id');
    }

    public function opportunityCompany()
    {
        return $this->hasMany(Opportunity::class, 'company_name');
    }
	public function getAvatarAttribute() {
		$val = $this->attributes['company_avatar'];
		if (strlen($val) > 1) {
			$val = asset( 'uploads/company' ) . '/' . $val;
		}
		return $val;
	}


}
