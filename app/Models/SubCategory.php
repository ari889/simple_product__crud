<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'name', 'slug'];

    /**
     * one to one relationship with category
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }

    /**
     * one to many relationship with product
     */
    public function products(){
        return $this->hasMany(Product::class);
    }
}
