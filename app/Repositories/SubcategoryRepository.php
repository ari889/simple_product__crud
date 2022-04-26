<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\SubCategory;

class SubcategoryRepository extends BaseRepository{

    /**
     * set column order
     */
    protected $order = array('id' => 'desc');
    protected $category;
    protected $name;
    protected $category_id;

    /**
     * fil model property from BaseRepository class
     */
    public function __construct(SubCategory $model, Category $category)
    {
        $this->model = $model;
        $this->category = $category;
    }

    /**
     * search datatable based on subcategory name
     */
    public function setName($name){
        $this->name = $name;
    }
    /**
     * search datatable based on category id
     */
    public function setCategoryID($category_id){
        $this->category_id = $category_id;
    }

    /**
     * set datatable query
     */
    public function get_datatable_query(){
        /**
         * set menu column order asc or desc
         */
        $this->column_order = [null, 'id', 'category_id', 'name', 'slug', null];

        $query = $this->model->with('category:id,name');

        /*******************
         * * Search Data **
         *******************/

         if(!empty($this->name)){
             $query->where('name', 'like', '%'.$this->name.'%');
         }
         if(!empty($this->category_id)){
             $query->where('category_id', $this->category_id);
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
     * get category data
     */
    public function categories(){
        return $this->category->all();
    }
}