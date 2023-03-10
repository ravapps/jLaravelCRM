<?php

namespace App\Models;

use App\Scopes\SalesOrderScope;
use App\Scopes\SalesOrderTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class Saleorder extends Model
{
    use SoftDeletes,RevisionableTrait, SalesOrderTrait;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
    protected $table = 'sales_orders';
    protected $appends = ['start_date','expire_date'];

    public function date_format()
    {
        return config('settings.date_format');
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::createFromFormat($this->date_format(),$date)->format('Y-m-d');
    }

    public function getStartDateAttribute()
    {
        if ('0000-00-00' == $this->date || '' == $this->date) {
            return '';
        } else {
            return date($this->date_format(), strtotime($this->date));
        }
    }

    public function setExpDateAttribute($exp_date)
    {
        $this->attributes['exp_date'] = Carbon::createFromFormat($this->date_format(),$exp_date)->format('Y-m-d');
    }

    public function getExpireDateAttribute()
    {
        if ('0000-00-00' == $this->exp_date || '' == $this->exp_date) {
            return '';
        } else {
            return date($this->date_format(), strtotime($this->exp_date));
        }
    }

    public function salesPerson()
    {
        return $this->belongsTo(User::class, 'sales_person_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function customercontact()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salesTeam()
    {
        return $this->belongsTo(Salesteam::class, 'sales_team_id');
    }

    public function salesOrderProducts()
    {
        return $this->belongsToMany(Product::class, 'sales_order_products')->withPivot('quantity', 'price');
    }

    public function salesOrderProductsDetailed()
    {
        return $this->belongsToMany(Product::class, 'sales_order_products');
    }

    public function salesOrderProductsList()
    {
        return $this->hasMany(SaleProductList::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SalesOrderScope);
    }
}
