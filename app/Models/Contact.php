<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'business_id',
        'type',
        'company_name',
        'first_name',
        'last_name',
        'full_name',
        'tax_id_type',
        'tax_id_number',
        'tax_name',
        'email',
        'phone_mobile',
        'phone_landline',
        'phone_alternate',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'zip_code',
        'shipping_address',
        'opening_balance',
        'credit_limit',
        'payment_term_value',
        'payment_term_type',
        'customer_group_id',
        'is_default',
        'status',
        'created_by',
    ];

    // Relaciones
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function customerGroup()
    {
        return $this->belongsTo(CustomerGroup::class);
    }
}
