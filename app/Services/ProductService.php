<?php


namespace App\Services;

use App\Models\Product as ModelProduct;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository as Product;
use App\Traits\UploadAble;
use Carbon\Carbon;

class ProductService extends BaseService{
    use UploadAble;
    /**
     * load subcategory repository
     */
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * get all category data in index method
     */
    public function index(){
        $data['subcategories'] = $this->product->subcategories();
        return $data;
    }

    /**
     * get datatable data from menu repository
     */
    public function get_datatable_data(Request $request){
        if($request->ajax()){
            if(!empty($request->title)){
                $this->product->setTitle($request->title);
            }
            if(!empty($request->subcategory_id)){
                $this->product->setSubcategoryID($request->subcategory_id);
            }
            if(!empty($request->min)){
                $this->product->setMin($request->min);
            }
            if(!empty($request->max)){
                $this->product->setMax($request->max);
            }

            $this->product->setOrderValue($request->input('order.0.column'));
            $this->product->setDirValue($request->input('order.0.dir'));
            $this->product->setLengthValue($request->input('length'));
            $this->product->setStartValue($request->input('start'));

            $list = $this->product->getDatatableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                
                /**
                 * menu edit link
                 */
                $action .= '<a href="#" class="dropdown-item edit_data" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';

                /**
                 * menu delete link
                 */
                $action .= '<a href="#" class="dropdown-item delete_data" data-id="'.$value->id.'" data-name="'.$value->title.'"><i class="fas fa-trash text-danger"></i> Delete</a>';


                $row = [];
                $row[] = table_checkbox($value->id);
                $row[] = $no;
                $row[] = "<img style='width:100px' src='".($value->thumbnail != null ? 'storage/'.PRODUCT_IMAGE_PATH.$value->thumbnail : 'images/blank_image.jpg')."' />";
                $row[] = $value->subcategory->name;
                $row[] = $value->title;
                $row[] = $value->price;
                $row[] = action_button($action);
                $data[] = $row;
            }

            return $this->datatable_draw($request->input('draw'), $this->product->count_all(), $this->product->count_filtered(), $data);
        }
    }

    /**
     * store or update data in database
     */
    public function store_or_update_data(Request $request){
        $collection = collect($request->validated())->except('image');
        $thumbnail = $request->old_image;
        if($request->hasFile('image')){
            $thumbnail = $this->upload_file($request->file('image'),PRODUCT_IMAGE_PATH);
            
            if(!empty($request->old_image)){
                $this->delete_file($request->old_image,PRODUCT_IMAGE_PATH);
            }
        }
        $collection = $collection->merge(compact('thumbnail'));
        $created_at = $updated_at = Carbon::now();
        if($request->update_id){
            $collection = $collection->merge(compact('updated_at'));
        }else{
            $collection = $collection->merge(compact('created_at'));
        }

        return $this->product->updateOrCreate(['id' => $request->update_id], $collection->all());
    }

    /**
     * get menu edit info
     */
    public function edit(Request $request){
        return $this->product->find($request->id);
    }

    /**
     * delete menu single data
     */
    public function delete(Request $request){
        $product = ModelProduct::find($request->id);
        $image = $product->thumbnail;
        $result = $this->product->delete($request->id);
        if($result){
            if(!empty($image)){
                $this->delete_file($image,PRODUCT_IMAGE_PATH);
            }
        }
        return $result;
    }

    /**
     * bulk delete data from database
     */
    public function bulk_delete(Request $request){
        $products = ModelProduct::select('thumbnail')->whereIn('id',$request->ids)->get();
        $result = $this->product->destroy($request->ids);
        if($result){
            if(!empty($products)){
                foreach ($products as $product) {
                    if($product->thumbnail){
                        $this->delete_file($product->thumbnail,PRODUCT_IMAGE_PATH);
                    }
                }
            }
        }

        return $result;
    }


}