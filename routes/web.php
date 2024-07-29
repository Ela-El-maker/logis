<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Home\HomeSliderController;
use App\Http\Controllers\Home\AboutController;
use App\Http\Controllers\Home\ProjectController;
use App\Http\Controllers\Home\ProjectCategoryController;
use App\Http\Controllers\Home\ServiceCategoryController;
use App\Http\Controllers\Home\ServiceController;
use App\Http\Controllers\Home\FeaturesController;
use App\Http\Controllers\Home\CustomerFeedbackController;
use App\Http\Controllers\Home\SummaryProgramController;
use App\Http\Controllers\Home\OurTeamController;
use App\Http\Controllers\Home\ContactUsController;
use App\Http\Controllers\Home\SectionSettingController;
use App\Http\Controllers\Home\LogosController;
use App\Http\Controllers\Home\FooterinfoController;
use App\Http\Controllers\Home\SocialLinksController;
use App\Http\Controllers\Home\HelpLinksController;
use App\Http\Controllers\Home\UsefulLinksController;







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

Route::controller(ServiceController::class)->group(function(){
    Route::get('/service', 'serviceItem')->name('add.service');
    Route::post('/store/service', 'storeService')->name('store.service');
    Route::get('/all/services/', 'allServices')->name('all.services');
    Route::get('/edit/service/{id}', 'editService')->name('edit.service');
    Route::post('/update/service/', 'updateService')->name('update.service');
    Route::delete('/delete/service/{id}', 'deleteService')->name('delete.service');
});

Route::controller(FeaturesController::class)->group(function(){
    Route::get('/feature', 'featureItem')->name('add.feature');
    Route::post('/store/feature', 'storeFeature')->name('store.feature');
    Route::get('/all/features/', 'allFeatures')->name('all.features');
    Route::get('/edit/feature/{id}', 'editFeature')->name('edit.feature');
    Route::post('/update/feature/', 'updateFeature')->name('update.feature');
    Route::delete('/delete/feature/{id}', 'deleteFeature')->name('delete.feature');
});




// Social Links routes
Route::controller(SocialLinksController::class)->group(function(){
    Route::get('/social', 'socialItem')->name('add.social');
    Route::post('/store/social', 'storeSocial')->name('store.social');
    Route::get('/all/socials/', 'allSocials')->name('all.socials');
    Route::get('/edit/social/{id}', 'editSocial')->name('edit.social');
    Route::post('/update/social/', 'updateSocial')->name('update.social');
    Route::delete('/delete/social/{id}', 'deleteSocial')->name('delete.social');
});

// Useful Links routes
Route::controller(UsefulLinksController::class)->group(function(){
    Route::get('/useful', 'usefulItem')->name('add.useful');
    Route::post('/store/useful', 'storeUseful')->name('store.useful');
    Route::get('/all/usefuls/', 'allUsefuls')->name('all.usefuls');
    Route::get('/edit/useful/{id}', 'editUseful')->name('edit.useful');
    Route::post('/update/useful/', 'updateUseful')->name('update.useful');
    Route::delete('/delete/useful/{id}', 'deleteUseful')->name('delete.useful');
});


// Help Links routes
Route::controller(HelpLinksController::class)->group(function(){
    Route::get('/help', 'helpItem')->name('add.help');
    Route::post('/store/help', 'storeHelp')->name('store.help');
    Route::get('/all/helps/', 'allHelps')->name('all.helps');
    Route::get('/edit/help/{id}', 'editHelp')->name('edit.help');
    Route::post('/update/help/', 'updateHelp')->name('update.help');
    Route::delete('/delete/help/{id}', 'deleteHelp')->name('delete.help');
});


// Feedback Routes
Route::get('/get/feedbacks',[CustomerFeedbackController::class, 'getFeedbacks'])->name('get.feedbacks');
Route::delete('/delete/feedbacks/{id}',[CustomerFeedbackController::class, 'deleteFeedbacks'])->name('delete.feedbacks');

// Contact Routes
Route::get('/get/contacts',[ContactUsController::class, 'getMessages'])->name('get.messages');
Route::delete('/delete/contacts/{id}',[ContactUsController::class, 'deleteMessages'])->name('delete.messages');


// Statistics Routes
Route::get('/summary',[SummaryProgramController::class, 'summary'])->name('summary.page');
Route::post('/update/summary', [SummaryProgramController::class, 'updateSummary'])->name('update.summary');


// FooterInfo Routes
Route::get('/footerInfo',[FooterinfoController::class, 'footerInfo'])->name('footerInfo.page');
Route::post('/update/footerInfo', [FooterinfoController::class, 'updateFooterInfo'])->name('update.footerInfo');


// Section Setting Routes
Route::get('/section',[SectionSettingController::class, 'section'])->name('section.page');
Route::post('/update/section', [SectionSettingController::class, 'updateSection'])->name('update.section');


// Our Team Routes
Route::get('/all/members',[OurTeamController::class, 'allTeamMembers'])->name('all.members');
Route::get('/members',[OurTeamController::class, 'addTeamMembers'])->name('add.member');
Route::post('/store/member',[OurTeamController::class, 'storeTeamMembers'])->name('store.member');
Route::get('/edit/member/{id}',[OurTeamController::class, 'editTeamMembers'])->name('edit.member');
Route::post('/update/member',[OurTeamController::class, 'updateTeamMembers'])->name('update.member');
Route::delete('/delete/member/{id}',[OurTeamController::class, 'deleteMember'])->name('delete.member');
// Logo Routes
Route::get('/logos',[LogosController::class, 'logosIndex'])->name('logos.index');
Route::post('/update/logos',[LogosController::class, 'updateLogos'])->name('update.logos');
// Route::post('/update-logos', [YourController::class, 'updateLogos'])->name('update.logos');




});

// Public Routes
Route::get('/about/page', [AboutController::class,'AboutPage'])->name('about.page');
Route::get('/projects/page', [ProjectController::class,'projectsPage'])->name('projects.page');
Route::get('/services/page', [ServiceController::class,'servicesPage'])->name('services.page');
Route::get('/features/page', [FeaturesController::class,'featuresPage'])->name('features.page');


Route::get('/project/details/{id}', [ProjectController::class,'HomeProjectDetails'])->name('home.project.details');
Route::get('/service/details/{id}', [ServiceController::class,'HomeServiceDetails'])->name('home.service.details');

Route::get('/category/project/{id}', [ProjectController::class, 'CategoryProject'])->name('category.project');
Route::get('/category/service/{id}', [ServiceController::class, 'CategoryService'])->name('category.service');
Route::get('/about',[AboutController::class, 'HomeAbout'])->name('home.about');

Route::get('/feedback',[CustomerFeedbackController::class, 'feedbackUs'])->name('feedback.us');
Route::post('/store/feedback',[CustomerFeedbackController::class, 'storeFeedback'])->name('store.feedback');
Route::get('/feedback',[CustomerFeedbackController::class, 'feedbackUs'])->name('feedback.us');

Route::get('/home/summary',[SummaryProgramController::class, 'homeSummary'])->name('home.summary');
Route::get('/home/section',[SectionSettingController::class, 'homeSection'])->name('home.section');



Route::get('/contact',[ContactUsController::class, 'contactUs'])->name('contact.us');
Route::post('/store/contact',[ContactUsController::class, 'storeContact'])->name('store.contact');





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
