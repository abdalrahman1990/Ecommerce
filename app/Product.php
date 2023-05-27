<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    /**
     *  Check if the product stock is
     *  lower than five.
     * 
     *  @return bool
     */
    public function hasLowStock(){
        if($this->outOfStock()){
            return false;
        }
        return $this->quantity <= 5;
    }

    /**
     *  Check if the product is out
     *  of stock.
     * 
     *  @return bool
     */
    public function outOfStock(){
        return $this->quantity === 0;
    }

    /**
     *  Check if the product has stock
     *  of atleast one.
     * 
     *  @return bool
     */
    public function inStock(){
        return $this->quantity >= 1;
    }

    /**
     *  Check if the product has the
     *  required stock.
     * 
     *  @return bool
     */
    public function hasStock($qty){
        return $this->quantity >= $qty;
    }

    /**
     * Get the category that owns the product
     */
    public function hasCategory(){
        return $this->belongsTo('App\Category','category');
    }

    /**
     *  We are creating a single order then,
     *  we are storing multiple products that has
     *  the same order with quantities.
     * 
     *  Many to Many Relationship
     */
    public function order(){
        return $this->belongsToMany('App\Order','orders_products')->withPivot('qty');
    }

    public function reviews(){
        return $this->hasMany('App\Review');
    }
}
