<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    /**
     * home route
     */
    Route::get('/', 'HomeController@index')->name('dashboard');
     

    // category routes
    Route::get('category', 'CategoryController@index')->name('category');
    Route::group(['prefix' => 'category', 'as' => 'category.'], function(){
        Route::post('datatable-data', 'CategoryController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'CategoryController@store_or_update')->name('store.or.update');
        Route::post('edit', 'CategoryController@edit')->name('edit');
        Route::post('delete', 'CategoryController@delete')->name('delete');
        Route::post('bulk-delete', 'CategoryController@bulk_delete')->name('bulk.delete');
    });

    // subcategory routes
    Route::get('subcategory', 'SubcategoryController@index')->name('subcategory');
    Route::group(['prefix' => 'subcategory', 'as' => 'subcategory.'], function(){
        Route::post('datatable-data', 'SubcategoryController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'SubcategoryController@store_or_update')->name('store.or.update');
        Route::post('edit', 'SubcategoryController@edit')->name('edit');
        Route::post('delete', 'SubcategoryController@delete')->name('delete');
        Route::post('bulk-delete', 'SubcategoryController@bulk_delete')->name('bulk.delete');
    });

    // subcategory routes
    Route::get('product', 'ProductController@index')->name('product');
    Route::group(['prefix' => 'product', 'as' => 'product.'], function(){
        Route::post('datatable-data', 'ProductController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'ProductController@store_or_update')->name('store.or.update');
        Route::post('edit', 'ProductController@edit')->name('edit');
        Route::post('delete', 'ProductController@delete')->name('delete');
        Route::post('bulk-delete', 'ProductController@bulk_delete')->name('bulk.delete');
    });
});
