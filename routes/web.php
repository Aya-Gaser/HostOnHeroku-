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
//Route::get('/','seedUser@index');

Route::get('/', function () {
    return view('auth.login');
});



//////////admins //////////////
Route::group(['middleware' => 'role:admin', 'prefix' => 'mangement-panel',
 'as' => 'management.'], function() {
    
    Route::get('/first-login', 'admins\dashboardController@first')->middleware('auth')
    ->name('first-login');
    Route::post('/first-login', 'admins\dashboardController@completeData')->middleware('auth')
    ->name('first-login');
    Route::get('/dashboard', 'admins\dashboardController@index')->middleware('auth')
    ->name('dashboard');
    Route::get('/my-profile', 'admins\dashboardController@profile')->middleware('auth')
    ->name('admin-profile'); 
    Route::post('/update-profile', 'admins\dashboardController@updateProfile')->middleware('auth')
    ->name('update-profile');

    Route::get('/createWo', 'projects\createWO@getAllData')->middleware('auth')->name('create-wo');
    Route::post('/createWo', 'projects\createWO@store')->middleware('auth')->name('create-wo');
    Route::post('/updateWo/{woId}', 'projects\viewWoController@updateWo')->middleware('auth')
    ->where(['woId'=>'[0-9]+'])->name('update-wo');
    
    Route::get('allWo', 'projects\allWoController@index')->middleware('auth')->name('view-allWo');
    Route::get('/viewWo/{id}', 'projects\viewWoController@index')->middleware('auth')->name('view-wo');
    Route::get('/recieve-wo/{wo}', 'projects\viewWoController@recieveWo')->middleware('auth')
    ->where(['wo'=>'[0-9]+'])->name('recieve-wo');
    //choose single / linked
    Route::get('/createProject-select/{id}', 'projects\createProjectController@selectProject_type')->middleware('auth')
    ->where(['id'=>'[0-9]+'])->name('select-projectType');
    //////createProject
    Route::get('/createProject-data/{id}/{type}', 'projects\createProjectController@index')->middleware('auth')
    ->where(['id'=>'[0-9]+', 'type'=> '[a-z]+'])->name('create-project');
    
    Route::get('/file-delete/{id}/{type}', 'projects\viewProjectController@deleteAttachment')
    ->where(['id'=>'[0-9]+', 'type'=>'[a-z]+'])->name('delete-file');
    //// store project
    Route::post('/createProject/{wo}/{isLinked}', 'projects\createProjectController@store')->middleware('auth')
    ->where(['wo'=>'[0-9]+', 'isLinked'=> '[0-1]'])->name('store-project');
    //// view project
    Route::get('/viewProject/{id}', 'projects\viewProjectController@index')->middleware('auth')
    ->where(['id'=>'[0-9]+'])->name('view-project');
    Route::post('/updateProject/{id}', 'projects\viewProjectController@updateProject')->middleware('auth')
    ->where(['id'=>'[0-9]+'])->name('update-project');

    Route::post('/updateStage/{id}', 'projects\viewProjectController@updateStage')->middleware('auth')
    ->where(['id'=>'[0-9]+'])->name('update-stage');
    Route::get('/view-allProjects/{status}', 'projects\allWoController@allProjects')->middleware('auth')
    ->where(['status'=> '[a-z]+'])->name('view-allProjects');
    /// delivery action 

    Route::get('/action-deliveryFile/{deliveryID}/{action}', 'projects\viewProjectController@deliveryFile_action')->middleware('auth')
    ->where(['deliveryID'=> '[0-9]+', 'action'=> '[a-z]+' ])->name('acion-on-deliveryFile');


    Route::post('/upload-editedFile/{project}/{sourceFile}', 'projects\viewProjectController@store_EditedFile')->middleware('auth')
    ->where(['project'=>'[0-9]+', 'sourceFile'=>'[0-9]+'])->name('upload-editedFile');

    Route::get('/delete-editedFile/{editedFile}', 'projects\viewProjectController@delete_EditedFile')->middleware('auth')
    ->where(['editedFile'=>'[0-9]+'])->name('delete-editedFile');

    Route::get('/sendTo-finalization/{sourceFile}', 'projects\viewProjectController@send_toFinalization')->middleware('auth')
    ->where(['sourceFile'=>'[0-9]+'])->name('send-toFinalization');

    Route::post('/upload-finalizedFile/{project}/{sourceFile}', 'projects\viewProjectController@store_finalizedFile')->middleware('auth')
    ->where(['project'=>'[0-9]+', 'sourceFile'=>'[0-9]+'])->name('upload-finalizedFile');

    Route::get('/delete-finalizedFile/{finalizedFile}', 'projects\viewProjectController@delete_finalizedFile')->middleware('auth')
    ->where(['editedFile'=>'[0-9]+'])->name('delete-finalizedFile');

    Route::get('/complete-sourceFile/{sourceFile}/{compelte}', 'projects\viewProjectController@complete_reOpen_sourceFile')->middleware('auth')
    ->where(['sourceFile'=>'[0-9]+', 'compelte'=> '[0-1]'])->name('complete-sourceFile');

    Route::get('/complete-projectStage/{stage}/{compelte}', 'projects\viewProjectController@complete_reOpen_vendorStage')->middleware('auth')
    ->where(['stage'=>'[0-9]+', 'compelte'=> '[0-1]'])->name('complete-stage');

    Route::get('/send-finalizedFile-toNext-project/{finalizedFile}', 'projects\viewProjectController@sendFinalized_toNextProject')->middleware('auth')
    ->where(['finalizedFile'=>'[0-9]+'])->name('send-toNextStage');

    Route::get('/tracking', 'projects\trackingController@index')->middleware('auth')
    ->name('projects-tracking');

    ////// view vendors

    Route::get('/view-allVendors', 'projects\vendorController@allVendors')->middleware('auth')
    ->name('view-allVendors');

    Route::get('/view-vendor/{vendor}', 'projects\vendorController@viewVendor')->middleware('auth')
    ->where(['vendor'=>'[0-9]+'])->name('view-vendor');
    //////// create vendor
    Route::post('/createVendor', 'projects\vendorController@createVendor')->middleware('auth')
    ->name('create-vendor');

    Route::post('/updateVendor-data/{vendor}', 'projects\vendorController@updateVendor')->middleware('auth')
    ->where(['vendor'=>'[0-9]+'])->name('update-vendor');

    Route::get('/delete-vendor/{vendor}', 'projects\vendorController@destroy')->middleware('auth')
    ->where(['vendor'=>'[0-9]+'])->name('delete-vendor');
    ////view clients
    Route::get('/view-allclients', 'projects\clientController@allclients')->middleware('auth')
    ->name('view-allClients');

    Route::get('/view-client/{client}', 'projects\clientController@viewclient')->middleware('auth')
    ->where(['client'=>'[0-9]+'])->name('view-client');
    //////// create client
    Route::post('/createclient', 'projects\clientController@createclient')->middleware('auth')
    ->name('create-client');

    Route::post('/updateclient-data/{client}', 'projects\clientController@updateclient')->middleware('auth')
    ->where(['client'=>'[0-9]+'])->name('update-client');

    Route::get('/delete-client/{client}', 'projects\clientController@destroy')->middleware('auth')
    ->where(['client'=>'[0-9]+'])->name('delete-client');


 
 });

////////////******************* * vendor *********************/////////////////
Route::group(['middleware' => 'role:vendor', 'prefix' => 'vendor-panel',
 'as' => 'vendor.'], function() {

    Route::get('/first-login', 'vendor\dashboardController@first')->middleware('auth')
    ->name('first-login');
    Route::post('/first-login', 'vendor\dashboardController@completeData')->middleware('auth')
    ->name('first-login');
    Route::get('/dashboard', 'vendor\dashboardController@index')->middleware('auth')
    ->name('dashboard');
    Route::get('/my-profile', 'vendor\dashboardController@profile')->middleware('auth')
    ->name('vendor-profile');
    Route::post('/update-profile', 'vendor\dashboardController@updateProfile')->middleware('auth')
    ->name('update-profile');

    ////////// offer/////////////////////
    Route::get('/project-offer/{stage_id}/{group}/{vendor}',
    array( 'uses' => 'vendor\viewOfferController@index'))->middleware('auth')
    ->where(['stage_id'=> '[0-9]+', 'group'=> '[1-2]', 'vendor'=> '[1-2]' ])
    ->name('project-offer');
    
    Route::get('/aceept-offer/{stage_id}/{group}/{vendor}',
    array( 'uses' => 'vendor\viewOfferController@acceptOffer'))->middleware('auth')
    ->where(['stage_id'=> '[0-9]+', 'group'=> '[1-2]', 'vendor'=> '[1-2]' ])
    ->name('accept-offer');
    Route::get('/decline-offer/{stage_id}/{group}/{vendor}',
    array('uses' => 'vendor\viewOfferController@declineOffer'))->middleware('auth')
    ->where(['stage_id'=> '[0-9]+', 'group'=> '[1-2]', 'vendor'=> '[1-2]' ])
    ->name('decline-offer');

    ///// projects /////////////// 
    Route::get('/my-projects/{filter}', 'vendor\viewAllProjectsController@index')->middleware('auth')
    ->where('filter', '[a-z]+')->name('view-myProjects'); 

    Route::get('/my-project/{id}', 'vendor\viewAllProjectsController@viewProject')->middleware('auth')
    ->where('id', '[0-9]+')->name('view-project');

    Route::post('/send-delivery/{stage}/{sourceFile}', 'vendor\viewAllProjectsController@storeDelivery')->middleware('auth')
    ->where(['stage'=> '[0-9]+', 'sourceFile'=> '[0-9]+' ])->name('send-delivery');

    Route::post('/REsend-delivery/{stage}/{delivery}', 'vendor\viewAllProjectsController@REsendDelivery')->middleware('auth')
    ->where(['stage'=> '[0-9]+', 'delivery'=> '[0-9]+' ])->name('resend-delivery');

    ///// editor in linked project acion-on-deliveryFile
    Route::get('/action-deliveryFile/{deliveryID}/{action}', 'vendor\viewAllProjectsController@deliveryFile_action')->middleware('auth')
    ->where(['deliveryID'=> '[0-9]+', 'action'=> '[a-z]+' ])->name('acion-on-deliveryFile');

 });

 Auth::routes();
