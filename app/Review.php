<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'text',
        'status',
        'rating',
    ];

    /**
     * One to One relationship (inverse) 
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * one to many relationship (inverse)
     */
    public function product(){
        return $this->belongsTo('App\Product');
    }
}
