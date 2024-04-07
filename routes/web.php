<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContractorContoller;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });



// auth
Route::get('/login', [AuthController::class, 'login']);
Route::post('/post_login', [AuthController::class, 'post_login']);
Route::get('/logout', [AuthController::class, 'logout']);


Route::middleware(['isLogin'])->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::get('/material_category', [MaterialController::class, 'material_category']);
    Route::post('/material_category/post_new_material_category', [MaterialController::class, 'post_new_material_category']);

    Route::get('/sub_material_category', [MaterialController::class, 'sub_material_category']);
    Route::post('/sub_material_category/post_edit_material_category/{id}', [MaterialController::class, 'post_edit_material_category']);
    Route::post('/sub_material_category/post_new_sub_material_category', [MaterialController::class, 'post_new_sub_material_category']);
    Route::get('/sub_material_category/delete/{id}', [MaterialController::class, 'delete_sub_material_category']);
    Route::post('/material/post_edit_material/edit/{id}', [MaterialController::class, 'post_edit_material']);

    // material
    Route::get('/material', [MaterialController::class, 'material']);
    Route::post('/material/post_new_material', [MaterialController::class, 'post_new_material']);
    Route::get('/material/delete/{id}', [MaterialController::class, 'delete_material']);
    Route::get('/material/get_material/{id}', [MaterialController::class, 'get_material']);

    Route::get('/job_category', [JobController::class, 'job_category']);
    Route::post('/post_new_job_category', [JobController::class, 'post_new_job_category']);
    Route::get('/job_category/delete/{id}', [JobController::class, 'delete_job_category']);

    Route::get('/job', [JobController::class, 'job']);
    Route::post('/job/post_new_job', [JobController::class, 'post_new_job']);
    Route::post('/job/update_job/{id}', [JobController::class, 'update_job']);
    Route::get('/job/get_table_search_job', [JobController::class, 'getTableSearchJob']);
    Route::get('/job/getJob/{id}', [JobController::class, 'getJob']);
    Route::get('/job/delete_job/{id}', [JobController::class, 'delete_job']);
    Route::get('/job/getMaterialOfJob/{id}', [JobController::class, 'getMaterialOfJob']);
    Route::get('/job/getMaterialOfMaterialCategory/{id}', [JobController::class, 'getMaterialOfMaterialCategory']);
    Route::post('/job/post_new_item_of_job', [JobController::class, 'post_new_item_of_job']);
    Route::get('/job/deleteItemOfJob/{id}', [JobController::class, 'deleteItemOfJob']);
    Route::get('/job/get_material_of_job/{id}', [JobController::class, 'get_material_of_job']);
    Route::get('/job/get_total_price/{id}', [JobController::class, 'get_total_price']);
    Route::post('/job/post_edit_material_of_job/{id}', [JobController::class, 'post_edit_material_of_job']);

    // project
    Route::get('/project', [ProjectController::class, 'project']);
    Route::get('/project/post_project/{id}', [ProjectController::class, 'post_project']);
    Route::get('/project/posting_project/{id}', [ProjectController::class, 'post_project']);
    Route::post('/project/post_new_project', [ProjectController::class, 'post_new_project']);
    Route::post('/project/post_update_project/{id}', [ProjectController::class, 'post_update_project']);
    Route::get('/project/get_table_list_job', [ProjectController::class, 'get_table_list_job']);
    Route::get('/project/get_table_list_project', [ProjectController::class, 'get_table_list_project']);
    Route::get('/project/get_project/{id}', [ProjectController::class, 'get_project']);
    // Route::get('/project/get_d_job_on_project/{id}', [ProjectController::class, 'get_d_job_on_project']);
    Route::get('/project/get_table_job_on_project/{id}', [ProjectController::class, 'get_table_job_on_project']);
    Route::get('/project/get_job/{id}', [ProjectController::class, 'get_job']);
    Route::get('/project/get_d_job_on_project/{id}', [ProjectController::class, 'get_d_job_on_project']);
    Route::post('/project/post_new_job/{project_id}/{job_id}', [ProjectController::class, 'post_new_job']);
    Route::get('/project/delete_d_job_on_project/{id}', [ProjectController::class, 'delete_d_job_on_project']);
    Route::delete('/project/project_summary/delete/{id}', [ProjectController::class, 'delete_project_summary']);
    Route::post('/project/post_edit_job/{id}', [ProjectController::class, 'post_edit_job']);

    Route::get('/project/export/material_and_price/{id}', [ProjectController::class, 'export_material_and_price']);
    Route::get('/project/export/list_materials/{id}', [ProjectController::class, 'export_recap_material']);
    Route::get('/project/export/recap_rab/{id}', [ProjectController::class, 'recap_rab']);

    // contractor
    Route::get('/contractor', [ContractorContoller::class, 'index']);
    Route::delete('/contractor/delete/{id}', [ContractorContoller::class, 'delete_contractor']);
    Route::get('/contractor/getTableSearchContractor', [ContractorContoller::class, 'getTableSearchContractor']);
    Route::get('/contractor/getContractor/{id}', [ContractorContoller::class, 'getContractor']);
    Route::post('/contractor/post_new_contractor', [ContractorContoller::class, 'post_new_contractor']);
    Route::post('/contractor/post_update_contractor/{id}', [ContractorContoller::class, 'post_update_contractor']);
});
