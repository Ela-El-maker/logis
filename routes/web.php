<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Home\HomeSliderController;
use App\Http\Controllers\Home\AboutController;
use App\Http\Controllers\Home\ProjectController;
use App\Http\Controllers\Home\ProjectCategoryController;
use App\Http\Controllers\Home\ServiceCategoryController;



Route::get('/', function () {
    return view('frontend.index');
});

Route::middleware(['auth'])->group(function(){


// Admin All routes
Route::controller(AdminController::class)->group(function(){
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
    Route::get('/admin/profile', 'Profile')->name('admin.profile');
    Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
    Route::post('/store/profile', 'StoreProfile')->name('store.profile');
    Route::get('/change/password', 'ChangePassword')->name('change.password');
    Route::post('/update/password', 'updatePassword')->name('update.password');




});

Route::controller(HomeSliderController::class)->group(function(){
    Route::get('/home/slide', 'HomeSlider')->name('home.slide');
    Route::post('/update/slide', 'UpdateSlider')->name('update.slide');
    
});

Route::controller(AboutController::class)->group(function(){
    Route::post('/update/about', 'updateAbout')->name('update.about');
    Route::get('/about/item/', 'aboutItem')->name('about.item');
    Route::post('/store/item/', 'storeItem')->name('store.item');
    Route::get('/all/item/', 'allItem')->name('all.item');
    Route::get('/edit/item/{id}', 'editItem')->name('edit.item');
    Route::post('/update/item/', 'updateItem')->name('update.item');
    // Route::get('/delete/item/{id}', 'deleteitem')->name('delete.item.');

});
Route::delete('/delete/item/{id}', [AboutController::class, 'deleteItem'])->name('delete.item');



Route::controller(ProjectCategoryController::class)->group(function(){
    Route::get('/all/project/category', 'allProjectCategory')->name('all.project.category');
    Route::get('/add/project/category', 'addProjectCategory')->name('add.project.category');
    Route::post('/store/project/category', 'storeProjectCategory')->name('store.project.category');
    Route::get('/edit/project/category/{id}', 'editProjectCategory')->name('edit.project.category');
    Route::post('/update/project/category', 'updateProjectCategory')->name('update.project.category');
    Route::delete('/delete/project/category/{id}', 'deleteProjectCategory')->name('delete.project.category');

});



Route::controller(ProjectController::class)->group(function(){
    Route::get('/project', 'projectItem')->name('add.project');
    Route::post('/store/project', 'storeProject')->name('store.project');
    Route::get('/all/projects/', 'allProjects')->name('all.projects');
    Route::get('/edit/project/{id}', 'editProject')->name('edit.project');
    Route::post('/update/project/', 'updateProject')->name('update.project');
    Route::delete('/delete/project/{id}', 'deleteProject')->name('delete.project');
});

// Route::delete('/delete/project/{id}', [ProjectController::class, 'deleteProject'])->name('delete.project');


Route::controller(ServiceCategoryController::class)->group(function(){
    Route::get('/all/service/category', 'allServiceCategory')->name('all.service.category');
    Route::get('/add/service/category', 'addServiceCategory')->name('add.service.category');
    Route::post('/store/service/category', 'storeServiceCategory')->name('store.service.category');
    Route::get('/edit/service/category/{id}', 'editServiceCategory')->name('edit.service.category');
    Route::post('/update/service/category', 'updateServiceCategory')->name('update.service.category');
    Route::delete('/delete/service/category/{id}', 'deleteServiceCategory')->name('delete.service.category');

});


});

// Public Routes
Route::get('/about/page', [AboutController::class,'AboutPage'])->name('about.page');
Route::get('/project/details/{id}', [ProjectController::class,'HomeProjectDetails'])->name('home.project.details');
Route::get('/about',[AboutController::class, 'HomeAbout'])->name('home.about');
Route::get('/category/project/{id}',[ProjectController::class, 'CategoryProject'])->name('category.project');




Route::get('/dashboard', function () {
    // return view('dashboard');
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
