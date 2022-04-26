<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubcategoryFormRequest;
use App\Services\SubcategoryService;
use Illuminate\Http\Request;

class SubcategoryController extends BaseController
{
    /**
     * load menu and module service
     */
    public function __construct(SubcategoryService $subcategory)
    {
        $this->service = $subcategory;
    }

    
    /**
     * load menu index route
     */
    public function index(){
        $this->setPageData('Sub-Category', 'Sub-Category', 'fas fa-th-list');
        $data = $this->service->index();
        return view('subcategory.index', compact('data'));
    }

    /**
     * get datatable data
     */
    public function get_datatable_data(Request $request){
        if($request->ajax()){
            $output = $this->service->get_datatable_data($request);
        }else{
            $output = ['status' => 'error', 'message' => 'Unauthorized access blocked!'];
        }

        return response()->json($output);
    }

    /**
     * store or update data
     */
    public function store_or_update(SubcategoryFormRequest $request){
        if($request->ajax()){
            $result = $this->service->store_or_update_data($request);
            if($result){
                return $this->response_json($status="success", $message="Data has been saved successfully!", $data=null, $response_code=200);
            }else{
                return $this->response_json($status="error", $message="Unauthorized access blocked!", $data=null, $response_code=204);
            }
        }else{
            return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    /**
     * edit category data
     */
    public function edit(Request $request){
        if($request->ajax()){
            $data = $this->service->edit($request);
            if($data->count() > 0){
                return $this->response_json($status="success", $message=null, $data=$data, $response_code=201);
            }else{
                return $this->response_json($status="error", $message="Data Not Found", $data=null, $response_code=204);
            }
        }else{
            return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    /**
     * delete category data
     */
    public function delete(Request $request){
        if($request->ajax()){
            $result = $this->service->delete($request);
            if($result){
                return $this->response_json($status="success", $message="Data deleted successfully!", $data=null, $response_code=200);
            }else{
                return $this->response_json($status="error", $message="Failed to delete data!", $data=null, $response_code=204);
            }
        }else{
            return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    /**
     * bulk delete data from database
     */
    public function bulk_delete(Request $request){
        if($request->ajax()){
            $result = $this->service->bulk_delete($request);
            if($result){
                return $this->response_json($status="success", $message="Data deleted successfully!", $data=null, $response_code=200);
            }else{
                return $this->response_json($status="error", $message="Failed to delete data!", $data=null, $response_code=204);
            }
        }else{
            return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }
}
