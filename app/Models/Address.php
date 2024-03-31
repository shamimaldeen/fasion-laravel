<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Address extends Model
{
    use HasFactory;
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;
    public const SUPPLIER_ADDRESS = 1;
    public const Sales_Manager_ADDRESS = 4;
    public const SHOP_ADDRESS = 5;
    public const CUSTOMER_PREADDRESS = 2;
    public const CUSTOMER_PER_ADDRESS = 3;
    protected $fillable = [
        'address',
        'division_id',
        'district_id',
        'area_id',
        'landmark',
        'status',
        'type',
        'addressable_type',
        'addressable_id',
    ];

    public  function prepareData(array $input)
       {
        $address['address'] = $input['address'] ?? '';
        $address['division_id'] = $input['division_id'] ?? '';
        $address['district_id'] = $input['district_id'] ?? '';
        $address['area_id'] = $input['area_id'] ?? '';
        $address['landmark'] = $input['landmark'] ?? '';
        $address['status'] = self::STATUS_ACTIVE;
        $address['type'] = self::SUPPLIER_ADDRESS;
        return $address;
      }

    public  function shopPrepareData(array $input)
    {
        $address['address'] = $input['address'] ?? '';
        $address['division_id'] = $input['division_id'] ?? '';
        $address['district_id'] = $input['district_id'] ?? '';
        $address['area_id'] = $input['area_id'] ?? '';
        $address['landmark'] = $input['landmark'] ?? '';
        $address['status'] = self::STATUS_ACTIVE;
        $address['type'] = self::SHOP_ADDRESS;
        return $address;
    }

    public  function salesPrepareData(array $input)
    {
        $address['address'] = $input['address'] ?? '';
        $address['division_id'] = $input['division_id'] ?? '';
        $address['district_id'] = $input['district_id'] ?? '';
        $address['area_id'] = $input['area_id'] ?? '';
        $address['landmark'] = $input['landmark'] ?? '';
        $address['status'] = self::STATUS_ACTIVE;
        $address['type'] = self::Sales_Manager_ADDRESS;
        return $address;
    }

    /**
     * Get the parent of the activity feed record.
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
