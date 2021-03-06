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
Route::get('/seed','seedUser@index');

Route::get('/linkstorage', function () {
   Artisan::call('storage:link');
});

Route::get('/', function () {
    return view('auth.login');
});



//////////admins //////////////
Route::group(['middleware' => 'role:admin', 'prefix' => 'mangement-panel',
 'as' => 'management.'], function() {
    /* HELPERS */ 
    Route::post('/helper_getStageQP', 'admins\helperController@getStage_qualityPoints')->middleware('auth')
    ->name('helper_getStageQP'); 
    Route::post('/helper_getStageInfo', 'admins\helperController@getStage_info')->middleware('auth')
    ->name('helper_getStage_info');
    Route::get('/first-login', 'admins\dashboardController@first')->middleware('auth')
    ->name('first-login');
    Route::post('/first-login', 'admins\dashboardController@completeData')->middleware('auth')
    ->name('first-login');
    Route::get('/dashboard', 'admins\dashboardController@index')->middleware('auth')
    ->name('dashboard');
    Route::get('/my-profile', 'admins\dashboardController@profile')->middleware('auth')
    ->name('admin-profile'); 
    Route::post('/update-profile/{userId}', 'admins\dashboardController@updateProfile')->middleware('auth')
    ->where(['userId'=>'[0-9]+'])->name('update-profile');

    Route::get('/seedClients_excel', 'admins\dashboardController@seedClients_excel')->middleware('auth')
    ->name('seedClients_excel');
    Route::get('/seedVendors_excel', 'admins\dashboardController@seedVendors_excel')->middleware('auth')
    ->name('seedVendors_excel');

    Route::get('/createWo', 'projects\createWO@getAllData')->middleware('auth')->name('create-wo');
    Route::post('/createWo', 'projects\createWO@store')->middleware('auth')->name('create-wo');
    Route::post('/updateWo/{woId}', 'projects\viewWoController@updateWo')->middleware('auth')
    ->where(['woId'=>'[0-9]+'])->name('update-wo');
    
    Route::post('/addTask/{woId}', 'projects\viewWoController@addTask')->middleware('auth')
    ->where(['woId'=>'[0-9]+'])->name('add-task');
    Route::post('/DeleteTask/{taskId}', 'projects\viewWoController@destroyTask')->middleware('auth')
    ->where(['taskId'=>'[0-9]+'])->name('delete-task');
    
    Route::get('allWo', 'projects\allWoController@index')->middleware('auth')->name('view-allWo');
    Route::get('/viewWo/{id}', 'projects\viewWoController@index')->middleware('auth')->name('view-wo');
   
    Route::post('/delete-woFile/{fileId}', 'projects\viewWoController@destroyWoFile')->middleware('auth')
    ->where(['fileId'=>'[0-9]+'])->name('delete-woFile');
    Route::post('/delete-wo/{woId}', 'projects\viewWoController@destroy')->middleware('auth')
    ->where(['woId'=>'[0-9]+'])->name('delete-wo');
    Route::get('/recieve-wo/{wo}', 'projects\viewWoController@recieveWo')->middleware('auth')
    ->where(['wo'=>'[0-9]+'])->name('recieve-wo');
    //choose single / linked
    Route::get('/createProject-select/{id}', 'projects\createProjectController@selectProject_type')->middleware('auth')
    ->where(['id'=>'[0-9]+'])->name('select-projectType');
    //////createProject
    Route::get('/createProject-data/{id}/{type}/{taskId}', 'projects\createProjectController@index')->middleware('auth')
    ->where(['id'=>'[0-9]+', 'type'=> '[a-z]+','taskId'=>'[0-9]+'])->name('create-project');
    
    Route::post('/file-delete/{id}/{type}', 'projects\viewProjectController@deleteAttachment')
    ->where(['id'=>'[0-9]+', 'type'=>'[a-z]+'])->name('delete-projectFile');
    Route::post('/delete-projectFile-woSource/{id}', 'projects\viewProjectController@deleteAttachment_woSourceToProject')
    ->where(['id'=>'[0-9]+'])->name('delete-projectFile-woSource');
    
    //// store project
    Route::post('/createProject/{wo}/{isLinked}', 'projects\createProjectController@store')->middleware('auth')
    ->where(['wo'=>'[0-9]+', 'isLinked'=> '[0-1]'])->name('store-project');
    //// view project
    Route::get('/viewProject/{id}', 'projects\viewProjectController@index')->middleware('auth')
    ->where(['id'=>'[0-9]+'])->name('view-project');
    Route::post('/delete-project/{projectId}', 'projects\viewProjectController@destroy')->middleware('auth')
    ->where(['projectId'=>'[0-9]+'])->name('delete-project');
    Route::post('/updateProject/{id}', 'projects\viewProjectController@updateProject')->middleware('auth')
    ->where(['id'=>'[0-9]+'])->name('update-project');

    Route::post('/updateStage/{id}', 'projects\viewProjectController@updateStage')->middleware('auth')
    ->where(['id'=>'[0-9]+'])->name('update-stage');
    Route::get('/view-allProjects/{status}', 'projects\allWoController@allProjects')->middleware('auth')
    ->where(['status'=> '[aA-zZ]+'])->name('view-allProjects');
    Route::get('/view-allProjects_type/{type}/{status}', 'projects\allWoController@allProjects_type_status')->middleware('auth')
    ->where(['status'=> '[aA-zZ]+', 'type'=>'[aA-zZ]+'])->name('view-allProjects_type');
    /// delivery action  allProjects_type_status

    Route::post('/action-deliveryFile', 'projects\viewProjectController@deliveryFile_action')->middleware('auth')
    ->where([])->name('acion-on-deliveryFile');
    Route::post('/store-improvedFile', 'projects\viewProjectController@deliveryFile_improve')->middleware('auth')
    ->where([])->name('store-improvedFile');


    Route::post('/upload-editedFile/{project}/{sourceFile}', 'projects\viewProjectController@store_EditedFile')->middleware('auth')
    ->where(['project'=>'[0-9]+', 'sourceFile'=>'[0-9]+'])->name('upload-editedFile');

    Route::get('/delete-editedFile/{editedFile}', 'projects\viewProjectController@delete_EditedFile')->middleware('auth')
    ->where(['editedFile'=>'[0-9]+'])->name('delete-editedFile');

    Route::get('/sendTo-finalization/{sourceFile}', 'projects\viewProjectController@send_toFinalization')->middleware('auth')
    ->where(['sourceFile'=>'[0-9]+'])->name('send-toFinalization');

    Route::post('/complete-projectStage', 'projects\viewProjectController@complete_reOpen_vendorStage')->middleware('auth')
    ->where([])->name('complete-stage');
    /* PROOFING */
    Route::get('/all-tasks-proofing/{filter}', 'projects\proofingController@index')->middleware('auth')
    ->where(['filter'=>'[aA-zZ]+'])->name('allTasks-proofing');
    Route::get('/task-proofing/{taskId}', 'projects\proofingController@taskProofing')->middleware('auth')
    ->where(['taskId'=>'[0-9]+'])->name('task-proofing');
    Route::post('/proof-workingFile', 'projects\proofingController@store_proofingFiles')->middleware('auth')
    ->name('store-proofingFiles'); 
    Route::post('/send-reviewToVendor', 'projects\proofingController@send_reviewToVendor')->middleware('auth')
    ->name('send-reviewToVendor');

    Route::post('/complete_reopen_proofingTask', 'projects\proofingController@complete_reOpen_proofingWoTask')->middleware('auth')
    ->name('complete_reopen_ProofingTask');
    
    /* FINALIZATION */ 
    Route::get('/all-tasks-finalization/{filter}', 'projects\finalizationController@index')->middleware('auth')
    ->where(['filter'=>'[aA-zZ]+'])->name('allTasks-finalization');
    Route::get('/task-finalization/{taskId}', 'projects\finalizationController@taskFinalization')->middleware('auth')
    ->where(['taskId'=>'[0-9]+'])->name('task-finalization');
    Route::post('/upload-finalizedFile/{taskId}', 'projects\finalizationController@store_finalizedFile')->middleware('auth')
    ->where(['taskId'=>'[0-9]+', 'type'=>'[aA-zZ]+'])->name('upload-finalizedFile');

    Route::get('/delete-finalizedFile/{finalizedFile}', 'projects\finalizationController@delete_finalizedFile')->middleware('auth')
    ->where(['editedFile'=>'[0-9]+'])->name('delete-finalizedFile');
    Route::post('/complete_reopen_task', 'projects\finalizationController@complete_reOpen_woTask')->middleware('auth')
    ->name('complete_reopen_task');

    
    Route::get('/complete-sourceFile/{sourceFile}/{compelte}', 'projects\finalizationController@complete_reOpen_sourceFile')->middleware('auth')
    ->where(['sourceFile'=>'[0-9]+', 'compelte'=> '[0-1]'])->name('complete-sourceFile');

    
    Route::get('/tracking', 'projects\trackingController@index')->middleware('auth')
    ->name('projects-tracking'); 
    Route::post('/archive-task/{taskId}', 'projects\trackingController@archiveTask')->middleware('auth')
    ->where(['taskId'=>'[0-9]+'])->name('archive-task');


    ////// view vendors

    Route::get('/view-allVendors', 'projects\vendorController@allVendors')->middleware('auth')
    ->name('view-allVendors');
    Route::get('/create-vendors', 'projects\vendorController@allVendors')->middleware('auth')
    ->name('create-vendors');

    Route::get('/view-vendor/{vendor}', 'projects\vendorController@viewVendor')->middleware('auth')
    ->where(['vendor'=>'[0-9]+'])->name('view-vendor');
    //////// create vendor
    Route::post('/createVendor', 'projects\vendorController@createVendor')->middleware('auth')
    ->name('create-vendor');

    Route::post('/updateVendor-data/{vendor}', 'projects\vendorController@updateVendor')->middleware('auth')
    ->where(['vendor'=>'[0-9]+'])->name('update-vendor');

    Route::post('/delete-vendor/{vendor}', 'projects\vendorController@destroy')->middleware('auth')
    ->where(['vendor'=>'[0-9]+'])->name('delete-vendor');
    ////view clients
    Route::get('/view-allclients', 'projects\clientController@allclients')->middleware('auth')
    ->name('view-allClients');
    Route::get('/create-clients', 'projects\clientController@allclients')->middleware('auth')
    ->name('create-clients');

    Route::get('/view-client/{client}', 'projects\clientController@viewclient')->middleware('auth')
    ->where(['client'=>'[0-9]+'])->name('view-client');
    //////// create client
    Route::post('/createclient', 'projects\clientController@createclient')->middleware('auth')
    ->name('create-client');

    Route::post('/updateclient-data/{client}', 'projects\clientController@updateclient')->middleware('auth')
    ->where(['client'=>'[0-9]+'])->name('update-client');

    Route::post('/delete-client/{client}', 'projects\clientController@destroy')->middleware('auth')
    ->where(['client'=>'[0-9]+'])->name('delete-client');
   ////////////////// INVOICES /////////////////
   Route::get('/view-allInvoices/{filtr}', 'invoice\invoiceController@viewAllInvoices')->middleware('auth')
   ->where(['filter'=>'[a-z]+'])->name('view-allInvoices'); 
   Route::get('/view-Invoice/{id}', 'invoice\invoiceController@viewInvoice')->middleware('auth')
   ->where(['id'=>'[0-9]+'])->name('view-invoice'); 
   Route::post('/invoice-action', 'invoice\invoiceController@actionOnInvoice')->middleware('auth')
   ->name('invoice-action');

   Route::get('/view-allReadyToPayInvoices/{f}', 'invoice\invoiceController@viewAllReadyToPayInvoices')->middleware('auth')
   ->where(['fltr'=>'[a-z]+'])->name('view-allReadyToPayInvoices'); 
   Route::get('/view-paymentInvoice/{id}', 'invoice\invoiceController@viewPaymentInvoice')->middleware('auth')
   ->where(['id'=>'[0-9]+'])->name('view-paymentInvoice'); 
   Route::post('/invoice-payment', 'invoice\invoiceController@payInvoice')->middleware('auth')
   ->name('invoice-payment'); 
   ///********************* */ invoice reports /********************* */
   
   Route::get('/view_vendorsInvoices-reports', 'invoice\invoiceReportsController@view_periodInvoices')->middleware('auth')
  ->name('view-vendorPeriodInvoices'); 
  Route::post('/view-filterd-vendorsInvoices-reports', 'invoice\invoiceReportsController@get_vendorFilterdInvoices')->middleware('auth')
  ->name('view-filterd-vendorInvoices');
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
    Route::post('/update-profile/{userId}', 'vendor\dashboardController@updateProfile')->middleware('auth')
    ->where(['userId'=>'[0-9]+'])->name('update-profile');

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
    ->where('filter', '[aA-zZ]+')->name('view-myProjects'); 

    Route::get('/my-project/{id}', 'vendor\viewAllProjectsController@viewProject')->middleware('auth')
    ->where('id', '[0-9]+')->name('view-project');

    Route::post('/send-delivery/{stage}/{sourceFile}', 'vendor\viewAllProjectsController@storeDelivery')->middleware('auth')
    ->where(['stage'=> '[0-9]+', 'sourceFile'=> '[0-9]+' ])->name('send-delivery');

    Route::post('/REsend-delivery/{stage}/{delivery}', 'vendor\viewAllProjectsController@REsendDelivery')->middleware('auth')
    ->where(['stage'=> '[0-9]+', 'delivery'=> '[0-9]+' ])->name('resend-delivery');

    ///// editor in linked project acion-on-deliveryFile
    Route::post('/action-deliveryFile', 'vendor\viewAllProjectsController@deliveryFile_action')->middleware('auth')
    ->where([])->name('acion-on-deliveryFile');
    /********************* INVOICE  ****************************/
    Route::get('ready-workOrder-invoices', 'vendor\invoice\invoiceController@viewReady_workOrderInvoices')->middleware('auth')
    ->name('view-readyWorkOrder-invoices');
    Route::get('create-workOrder-invoice/{stageId}', 'vendor\invoice\invoiceController@generateProjectInvoice')->middleware('auth')
    ->where('stageId', '[0-9]+')->name('create-workInvoice');
    Route::post('add-workOrder-invoice', 'vendor\invoice\invoiceController@addProjectInvoice')->middleware('auth')
    ->name('add-workInvoice'); 

    Route::get('create-nonWork-invoice', 'vendor\invoice\invoiceController@createNonWorkInvoice')->middleware('auth')
    ->name('create-nonWorkInvoice');
    Route::post('add-nonWork-invoice', 'vendor\invoice\invoiceController@addNonWorkInvoice')->middleware('auth')
    ->name('add-nonWorkInvoice'); 
    
    Route::get('view-allInvoices/{f}', 'vendor\invoice\invoiceController@viewAllInvoices')->middleware('auth')
    ->name('view-vendorAllInvoices');
    
    Route::get('view-Invoice/{invoiceId}', 'vendor\invoice\invoiceController@viewInvoice')->middleware('auth')
    ->where('invoiceId', '[0-9]+')->name('view-vendorInvoice');

    Route::post('submit-invoice', 'vendor\invoice\invoiceController@submitInvoice')->middleware('auth')
    ->name('submit-invoice'); 

    Route::get('view-edit-nonWork-invoice/{id}', 'vendor\invoice\invoiceController@view_editNonWorkInvoice')->middleware('auth')
    ->where('id', '[0-9]+')->name('view-editNonWorkInvoice');
    Route::post('edit-nonWork-invoice', 'vendor\invoice\invoiceController@editNonWorkInvoice')->middleware('auth')
    ->name('edit-nonWorkInvoice'); 

    Route::get('view-edit-Work-invoice/{id}', 'vendor\invoice\invoiceController@view_editWorkInvoice')->middleware('auth')
    ->where('id', '[0-9]+')->name('view-editWorkInvoice');
    Route::post('edit-Work-invoice', 'vendor\invoice\invoiceController@editProjectInvoice')->middleware('auth')
    ->name('edit-workInvoice'); 

    Route::post('delete-invoiceItem', 'vendor\invoice\invoiceController@destroyInvoiceItem')->middleware('auth')
    ->name('delete-invoiceItem'); 
    
 });

 Auth::routes();
 
