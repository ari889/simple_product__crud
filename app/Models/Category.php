<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * one to many relationship with subcategories
     */
    public function subcategories(){
        return $this->hasMany(SubCategory::class);
    }
}
