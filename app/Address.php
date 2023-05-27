<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address_1',
        'address_2',
        'city_id',
        'postal_code',
    ];

    /**
     * One to Many relationship
     */
    public function orders(){
        return $this->hasMany('App\Order');
    }

    /**
     * one to many inverse
     */
    public function city(){
        return $this->belongsTo('App\City','city_id');
    }
}
