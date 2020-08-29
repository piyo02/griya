<?php

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
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => [ 'auth'] ], function(){
    Route::resource('/profiles', 'User\ProfileController');
});

Route::group(['middleware' => [ 'auth', 'role:admin'] ], function(){
    Route::resource('/accounts', 'User\AccountController');
    Route::get('/s-admin', 'S_admin\HomeController@index')->name('s-admin');
    Route::resource('/roles', 'S_admin\RoleController');

    Route::get('/menus_role/{role}', 'S_admin\MenuController@role')->name("menu_role");
    Route::resource('/menus', 'S_admin\MenuController');

});

Route::group(['middleware' => [ 'auth', 'role:admin|uadmin'] ], function(){
    Route::resource('/users', 'S_admin\UsersManagementController');
});

Route::group(['middleware' => [ 'auth', 'role:uadmin'] ], function(){
    Route::resource('/cash_transfer', 'U_admin\CashTransferController');
    Route::resource('/type', 'U_admin\TypeController');
    
    Route::post('/cash_out/export_excel', 'U_admin\CashOutController@export_excel');
    Route::post('/cash_out/export_pdf', 'U_admin\CashOutController@export_pdf');
    Route::resource('/cash_out', 'U_admin\CashOutController');
    
    // customer payment
    Route::post('/cash_in/export_excel', 'U_admin\CashInController@export_excel');
    Route::post('/cash_in/export_pdf', 'U_admin\CashInController@export_pdf');
    Route::resource('/cash_in', 'U_admin\CashInController');
    
    Route::post('/cluster/export_excel', 'U_admin\ClusterController@export_excel');
    Route::post('/cluster/export_pdf', 'U_admin\ClusterController@export_pdf');
    Route::resource('/cluster', 'U_admin\ClusterController');

    Route::put('/customer/{id}/edit_order', 'U_admin\CustomerController@edit_order');
    Route::post('/customer/export_excel', 'U_admin\CustomerController@export_excel');
    Route::post('/customer/export_pdf', 'U_admin\CustomerController@export_pdf');
    Route::resource('/customer', 'U_admin\CustomerController');
    
    //fee
    Route::get('/sales/export_excel', 'U_admin\SalesController@export_excel');
    Route::get('/sales/export_pdf', 'U_admin\SalesController@export_pdf');
    Route::resource('/sales', 'U_admin\SalesController');

    //cash flow
    Route::post('/account/export_excel', 'U_admin\AccountController@export_excel');
    Route::post('/account/export_pdf', 'U_admin\AccountController@export_pdf');
    Route::resource('/account', 'U_admin\AccountController');    
});