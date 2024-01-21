<?php

use App\Http\Controllers\AgeRateController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\FeaturedController;
use App\Http\Controllers\FreeShortController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeSectionController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SectionController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/categories', CategoryController::class)->names('categories');    

    Route::resource('/genres', GenreController::class)->names('genres');    

    Route::resource('/directors', DirectorController::class)->names('directors');    

    Route::resource('/movies', MovieController::class)->names('movies');    

    Route::get('/featured', [FeaturedController::class, 'index'])->name('featured.index');

    Route::post('/featured/add', [FeaturedController::class, 'add'])->name('featured.add');

    Route::post('/featured/remove', [FeaturedController::class, 'remove'])->name('featured.remove');

    Route::get('/featured/list', [FeaturedController::class, 'list'])->name('featured.list');

    Route::get('/freeshort', [FreeShortController::class, 'index'])->name('freeshort.index');

    Route::post('/freeshort/add', [FreeShortController::class, 'add'])->name('freeshort.add');

    Route::post('/freeshort/remove', [FreeShortController::class, 'remove'])->name('freeshort.remove');

    Route::get('/freeshort/list', [FreeShortController::class, 'list'])->name('freeshort.list');

    Route::get('/package', [PackageController::class, 'index'])->name('package.index');

    Route::post('/package/add', [PackageController::class, 'add'])->name('package.add');

    Route::get('/package/list', [PackageController::class, 'list'])->name('package.list');

    Route::post('/package/edit', [PackageController::class, 'edit'])->name('package.edit');

    Route::post('/package/remove', [PackageController::class, 'remove'])->name('package.remove');

    Route::get('/detail/{packageId}', [PackageController::class, 'detail'])->name('package.detail');

    Route::post('/package/addmovie', [PackageController::class, 'addmovie'])->name('package.addmovie');

    Route::get('/package/movielist', [PackageController::class, 'movielist'])->name('package.movielist');

    Route::post('/package/removemovie', [PackageController::class, 'removemovie'])->name('package.removemovie');

    Route::get('/languages', [LanguageController::class, 'index'])->name('languages.index');
    
    Route::get('/languages/list', [LanguageController::class, 'list'])->name('languages.list');

    Route::post('/languages/add', [LanguageController::class, 'add'])->name('languages.add');

    Route::post('/languages/edit', [LanguageController::class, 'edit'])->name('languages.edit');

    Route::post('/languages/remove', [LanguageController::class, 'remove'])->name('languages.remove');

    Route::get('/agerates', [AgeRateController::class, 'index'])->name('agerates.index');
    
    Route::get('/agerates/list', [AgeRateController::class, 'list'])->name('agerates.list');

    Route::post('/agerates/add', [AgeRateController::class, 'add'])->name('agerates.add');

    Route::post('/agerates/edit', [AgeRateController::class, 'edit'])->name('agerates.edit');

    Route::post('/agerates/remove', [AgeRateController::class, 'remove'])->name('agerates.remove');

    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    
    Route::get('/sections/list', [SectionController::class, 'list'])->name('sections.list');

    Route::post('/sections/add', [SectionController::class, 'add'])->name('sections.add');

    Route::post('/sections/edit', [SectionController::class, 'edit'])->name('sections.edit');

    Route::post('/sections/remove', [SectionController::class, 'remove'])->name('sections.remove');

    Route::get('/homesection', [HomeSectionController::class, 'index'])->name('homesection.index');
    
    Route::get('/homesection/list', [HomeSectionController::class, 'list'])->name('homesection.list');

    Route::post('/homesection/add', [HomeSectionController::class, 'add'])->name('homesection.add');

    Route::post('/homesection/remove', [HomeSectionController::class, 'remove'])->name('homesection.remove');

    Route::get('/detailhsection/{id}', [HomeSectionController::class, 'detail'])->name('homesection.detail');

    Route::get('/homesection/movielist', [HomeSectionController::class, 'movielist'])->name('homesection.movielist');

    Route::post('/homesection/addmovie', [HomeSectionController::class, 'addmovie'])->name('homesection.addmovie');

    Route::post('/homesection/removemovie', [HomeSectionController::class, 'removemovie'])->name('homesection.removemovie');

    Route::post('/homesection/edit', [HomeSectionController::class, 'edit'])->name('homesection.edit');
});

require __DIR__.'/auth.php';
