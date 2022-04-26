<?php


namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository as Category;
use Carbon\Carbon;

class CategoryService extends BaseService{

    /**
     * load category repository
     */
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * get datatable data from menu repository
     */
    public function get_datatable_data(Request $request){
        if($request->ajax()){
            if(!empty($request->name)){
                $this->category->setName($request->name);
            }

            $this->category->setOrderValue($request->input('order.0.column'));
            $this->category->setDirValue($request->input('order.0.dir'));
            $this->category->setLengthValue($request->input('length'));
            $this->category->setStartValue($request->input('start'));

            $list = $this->category->getDatatableList();

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
                $action .= '<a href="#" class="dropdown-item delete_data" data-id="'.$value->id.'" data-name="'.$value->name.'"><i class="fas fa-trash text-danger"></i> Delete</a>';


                $row = [];
                $row[] = table_checkbox($value->id);
                $row[] = $no;
                $row[] = $value->name;
                $row[] = $value->slug;
                $row[] = action_button($action);
                $data[] = $row;
            }

            return $this->datatable_draw($request->input('draw'), $this->category->count_all(), $this->category->count_filtered(), $data);
        }
    }

    /**
     * store or update data in database
     */
    public function store_or_update_data(Request $request){
        $collection = collect($request->validated());
        $created_at = $updated_at = Carbon::now();
        if($request->update_id){
            $collection = $collection->merge(compact('updated_at'));
        }else{
            $collection = $collection->merge(compact('created_at'));
        }

        return $this->category->updateOrCreate(['id' => $request->update_id], $collection->all());
    }

    /**
     * get menu edit info
     */
    public function edit(Request $request){
        return $this->category->find($request->id);
    }

    /**
     * delete menu single data
     */
    public function delete(Request $request){
        return $this->category->delete($request->id);
    }

    /**
     * bulk delete data from database
     */
    public function bulk_delete(Request $request){
        return $this->category->destroy($request->ids);
    }


}