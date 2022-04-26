<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'subcategory_id', 'price', 'thumbnail'];

    /**
     * one to one relationship with subcategory
     */
    public function subcategory(){
        return $this->belongsTo(SubCategory::class);
    }
}
