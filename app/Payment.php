<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     *  Attributes that are mass assignable.
     *  
     *  @var array
     */
    protected $fillable = [
        'failed',
        'transaction_id',
    ];
}
