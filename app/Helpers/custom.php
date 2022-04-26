<?php

/**
 * action button dropdown menu
 */
if(!function_exists('action_button')){
    function action_button($action){
        return '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-th-list text-white"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        '.$action.'
                    </ul>
                </div>
        ';
    }
}

/**
 * datatable bulk delete checkbox
 */
if(!function_exists('table_checkbox')){
    function table_checkbox($id){
        return '
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="'.$id.'" class="custom-control-input select_data" onchange="select_single_item('.$id.')" id="checkbox'.$id.'" />
                <label class="custom-control-label" for-"checkbox'.$id.'"></label>
            </div>
        ';
    }
}

/**
 * product image path
 */
define('PRODUCT_IMAGE_PATH', 'products/');