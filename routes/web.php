<?php

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\AttcodegeneratorsController;
use App\Http\Controllers\AttendancesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CitiesControler;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\CountriesControler;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\DaysController;
use App\Http\Controllers\EdulinksController;
use App\Http\Controllers\EnrollsController;
use App\Http\Controllers\GendersControler;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\PaymentmethodsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostsLikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelativesController;
use App\Http\Controllers\RolesControler;
use App\Http\Controllers\SocialapplicationsController;
use App\Http\Controllers\StagesController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\StatusesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\TypesController;
use App\Http\Controllers\UsersFollowerController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/dashboards',[DashboardsController::class,'index'])->name('dashboard.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('announcements',AnnouncementsController::class);

    Route::resource('attcodegenerators',AttcodegeneratorsController::class);
    Route::get('/attcodegeneratorsstatus', [AttcodegeneratorsController::class,'typestatus']);

    Route::resource('attendances',AttendancesController::class);

    Route::resource('categories',CategoriesController::class);
    Route::get('categoriesstatus',[CategoriesController::class,'typestatus']);

    Route::resource('cities',CitiesControler::class);
    Route::resource('comments',CommentsController::class);
    Route::resource('contacts',ContactsController::class);
    Route::resource('countries',CountriesControler::class);

    Route::resource('days',DaysController::class);
    Route::get('daysstatus',[DaysController::class,'typestatus']);

    Route::resource('edulinks',EdulinksController::class);
    Route::resource('enrolls',EnrollsController::class);
    Route::resource('genders',GendersControler::class);

    Route::resource('leaves',LeavesController::class);
    Route::get('notify/markasread',[LeavesController::class,'markasread'])->name('leaves.markasread');

    Route::resource('paymentmethods',PaymentmethodsController::class);
    Route::get('/paymentmethodsstatus', [PaymentmethodsController::class,'typestatus']);

    Route::resource('posts',PostsController::class);
    Route::post('posts/{post}/like',[PostsLikeController::class,'like'])->name('post.like');
    Route::post('posts/{post}/unlike',[PostsLikeController::class,'unlike'])->name('post.unlike');

    Route::resource('relatives',RelativesController::class);
    Route::get('/relativesstatus',[RelativesController::class,'typestatus']);
    
    Route::resource('roles',RolesControler::class);
    Route::get('/rolesstatus',[RolesControler::class,'typestatus']);

    Route::resource('students',StudentsController::class);
    Route::post('compose/mailbox',[StudentsController::class,'mailbox'])->name('students.mailbox');

    Route::resource('socialapplications',SocialapplicationsController::class);
    Route::get('/socialapplicationsstatus',[SocialapplicationsController::class,'typestatus']);
    Route::get('/socialapplicationsfetchalldata',[SocialapplicationsController::class,'fetchalldatas'])->name('socialapplications.fetchalldata');

    Route::resource('stages',StagesController::class);
    Route::get('/stagesstatus',[StagesController::class,'typestatus']);

    Route::resource('statuses',StatusesController::class);

    Route::resource('tags',TagsController::class);
    Route::get('/tagsstatus',[TagsController::class,'typestatus']);
    
    Route::resource('types',TypesController::class)->except('destroy');
    Route::get('/typesstatus',[Typescontroller::class,'typestatus']);
    Route::get('/typesdelete',[Typescontroller::class,'destroy'])->name('types.delete');

    Route::post('users/{user}/follow',[UsersFollowerController::class,'follow'])->name('users.follow');
    Route::post('users/{user}/unfollow',[UsersFollowerController::class,'unfollow'])->name('users.unfollow');

}
);

require __DIR__.'/auth.php';
