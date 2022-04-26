<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\SubCategory;

class ProductRepository extends BaseRepository{

    /**
     * set column order
     */
    protected $order = array('id' => 'desc');
    protected $title;
    protected $subcategory_id;
    protected $min;
    protected $max;

    /**
     * fil model property from BaseRepository class
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * search datatable based on title
     */
    public function setTitle($title){
        $this->title = $title;
    }
    /**
     * search datatable based on title
     */
    public function setSubcategoryID($subcategory_id){
        $this->subcategory_id = $subcategory_id;
    }
    /**
     * search datatable based on min
     */
    public function setMin($min){
        $this->min = $min;
    }
    /**
     * search datatable based on max
     */
    public function setMax($max){
        $this->max = $max;
    }

    /**
     * set datatable query
     */
    public function get_datatable_query(){
        /**
         * set menu column order asc or desc
         */
        $this->column_order = [null, 'id', 'thumbnail', 'subcategory_id', 'title', 'price', null];
        
        $query = $this->model->with('subcategory:id,name');
        
        /*******************
         * * Search Data **
         *******************/
        
        if(!empty($this->title)){
            $query->where('title', 'like', '%'.$this->title.'%');
        }
        if(!empty($this->subcategory_id)){
            $query->where('subcategory_id', $this->subcategory_id);
        }
        if(!empty($this->min)){
            $query->where('price', '>=', $this->min);
        }
        if(!empty($this->max)){
            $query->where('price', '<=', $this->max);
        }

         /**
          * set column order value
          */
          if(isset($this->column_order) && isset($this->dirValue)){
              $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
          }else if(isset($this->order)){
              $query->orderBy(key($this->order), $this->order[key($this->order)]);
          }

          return $query;
    }

    /**
     * get datatable data using datatable query
     */
    public function getDatatableList(){
        $query = $this->get_datatable_query();
        if($this->lengthValue != 1){
            $query->offset($this->startValue)->limit($this->lengthValue);
        }
        return $query->get();
    }

    /**
     * count datatable filtered data
     */
    public function count_filtered(){
        $query = $this->get_datatable_query();
        return $query->get()->count();
    }

    /**
     * count all data from database
     */
    public function count_all(){
        return $this->model->toBase()->get()->count();
    }

    /**
     * get all subcategories
     */
    public function subcategories(){
        return SubCategory::all();
    }
}