<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function createForOrder(array $data)
    {
        $address = $data['address'];
        if (!empty($address['id'])) {
            return static::find($address['id']);
        }

        $address['user_id'] = $data['user_id'];
        $address['type'] = $data['type'];

        return Address::create($address);
    }
}
