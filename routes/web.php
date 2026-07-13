<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\WebinarFrameworkBonusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FundedAccountController;
use App\Http\Controllers\Admin\MarketingSectionController;
use App\Http\Controllers\Admin\ProblemSectionController;
use App\Http\Controllers\Admin\WebinarController;
use App\Http\Controllers\Admin\WebinarHeroController;
use App\Http\Controllers\Admin\WebinarModuleController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\TestimonialController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::post('/webinar-register', [FrontendController::class, 'webinarRegister'])
    ->name('webinar.register');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
        Route::get('/settings', [AuthController::class, 'settings'])->name('settings');
        Route::post('/settings/update', [AuthController::class, 'updateSettings'])->name('settings.update');
        
        Route::resource('webinars', WebinarController::class);
        Route::resource('faqs', FaqController::class);
        Route::resource('abouts', AboutController::class);
        Route::resource('problem', ProblemSectionController::class);
        Route::resource('testimonials', TestimonialController::class);
        
        Route::get('marketing', [MarketingSectionController::class, 'edit'])->name('marketing.edit');
        Route::post('marketing/store', [MarketingSectionController::class, 'store'])->name('marketing.store');
        Route::get('webinar-modules', [WebinarModuleController::class, 'edit'])->name('webinar-modules.edit');
        Route::post('webinar-modules/store', [WebinarModuleController::class, 'store'])->name('webinar-modules.store');
        Route::get('framework-bonuses', [WebinarFrameworkBonusController::class, 'edit'])->name('framework-bonuses.edit');
        Route::post('framework-bonuses/store', [WebinarFrameworkBonusController::class, 'store'])->name('framework-bonuses.store');
        Route::get('funded-section', [FundedAccountController::class, 'edit'])
        ->name('funded-section.edit');
        
        // Dynamic AJAX update handler route
        Route::post('funded-section/update', [FundedAccountController::class, 'update'])
            ->name('funded-section.update');

        });
        Route::get('/webinar-hero', [WebinarHeroController::class, 'index'])->name('hero.index');
    
        // Save configurations layout action
        Route::post('/webinar-hero/store', [WebinarHeroController::class, 'store'])->name('hero.store');
        
        Route::get('/email-template', [EmailTemplateController::class, 'index'])->name('email-template.index');
    
        // Save/Update Settings Route
        Route::post('/email-template/store', [EmailTemplateController::class, 'store'])->name('email-template.store');
});