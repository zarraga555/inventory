<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerGroup extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'business_id',
        'name',
        'amount',
        'price_calculation_type',
        'selling_price_group_id',
        'created_by',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // public function sellingPriceGroup()
    // {
    //     return $this->belongsTo(SellingPriceGroup::class);
    // }
}
