<?php

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\AttcodegeneratorsController;
use App\Http\Controllers\AttendancesController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\DaysController;
use App\Http\Controllers\EdulinksController;
use App\Http\Controllers\EnrollsController;
use App\Http\Controllers\GendersController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\OtpsController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\PaymentmethodsController;
use App\Http\Controllers\PaymenttypesController;
use App\Http\Controllers\PermissionRolesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\PointTransfersController;
use App\Http\Controllers\PostLiveViewersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostsLikeController;
use App\Http\Controllers\PostViewDurationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegionsController;
use App\Http\Controllers\RelativesController;
use App\Http\Controllers\ReligionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SocialapplicationsController;
use App\Http\Controllers\StagesController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\StatusesController;
use App\Http\Controllers\StudentPhonesController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\TownshipsController;
use App\Http\Controllers\TypesController;
use App\Http\Controllers\UserPoinstsController;
use App\Http\Controllers\UsersFollowerController;
use App\Http\Controllers\WarehousesController;
use App\Models\Announcement;
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

Route::get('/register/step1',[RegisteredUserController::class,'createstep1'])->name('register.step1');
Route::post('/register/step1',[RegisteredUserController::class,'storestep1'])->name('register.storestep1');

Route::get('/register/step2',[RegisteredUserController::class,'createstep2'])->name('register.step2')->middleware('check.registration.step:step2');
Route::post('/register/step2',[RegisteredUserController::class,'storestep2'])->name('register.storestep2');

Route::get('/register/step3',[RegisteredUserController::class,'createstep3'])->name('register.step3')->middleware('check.registration.step:step3');
Route::post('/register/step3',[RegisteredUserController::class,'storestep3'])->name('register.storestep3');

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')
Route::middleware(['auth','autologout','verified'])->group(function () {

    Route::middleware(['roles:Admin,Teacher'])->group(function(){
        // Route::resource('announcements',AnnouncementsController::class);

        Route::get('announcements',[AnnouncementsController::class,'index'])->name('announcements.index');
        Route::get('announcements/create',[AnnouncementsController::class,'create'])->name('announcements.create');
        Route::post('announcements',[AnnouncementsController::class,'store'])->name('announcements.store');
        Route::get('announcements/{post}',[AnnouncementsController::class,'show'])->name('announcements.show');
        Route::get('announcements/{post}/edit',[AnnouncementsController::class,'edit'])->name('announcements.edit');
        Route::put('announcements/{post}',[AnnouncementsController::class,'update'])->name('announcements.update');
        Route::delete('announcements/{post}',[AnnouncementsController::class,'delete'])->name('announcements.destroy');


        Route::delete('/announcementsbulkdelete',[AnnouncementsController::class,'bulkdeletes'])->name('announcements.bulkdeletes');
    });

    Route::get('/dashboards',[DashboardsController::class,'index'])->name('dashboard.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    

    Route::resource('attcodegenerators',AttcodegeneratorsController::class);
    Route::get('/attcodegeneratorsstatus', [AttcodegeneratorsController::class,'typestatus']);
    Route::delete('/attcodegeneratorsbulkdelete',[AttcodegeneratorsController::class,'bulkdeletes'])->name('attcodegenerators.bulkdeletes');

    
    Route::delete('/attendancesbulkdelete',[AttendancesController::class,'bulkdeletes'])->name('attendances.bulkdeletes');

    Route::get('/carts',[CartsController::class,'index'])->name('carts.index');
    Route::post('/carts/add',[CartsController::class,'add'])->name('carts.add');
    Route::post('/carts/remove',[CartsController::class,'remove'])->name('carts.remove');
    Route::post('/carts/paybypoints',[CartsController::class,'paybypoints'])->name('carts.paybypoints');



    Route::resource('categories',CategoriesController::class);
    Route::get('categoriesstatus',[CategoriesController::class,'typestatus']);
    Route::delete('/categoriesbulkdelete',[CategoriesController::class,'bulkdeletes'])->name('categories.bulkdeletes');

    Route::resource('cities',CitiesController::class);
    Route::delete('/citiesbulkdelete',[CitiesController::class,'bulkdeletes'])->name('cities.bulkdeletes');


    Route::resource('comments',CommentsController::class);

    Route::resource('contacts',ContactsController::class);
    Route::delete('/contactsbulkdelete',[ContactsController::class,'bulkdeletes'])->name('contacts.bulkdeletes');

    Route::resource('countries',CountriesController::class);
    Route::delete('/countriesbulkdelete',[CountriesController::class,'bulkdeletes'])->name('countries.bulkdeletes');
    Route::get('countriesstatus',[CountriesController::class,'typestatus']);

    Route::resource('days',DaysController::class);
    Route::get('daysstatus',[DaysController::class,'typestatus']);
    Route::delete('/daysbulkdelete',[DaysController::class,'bulkdeletes'])->name('days.bulkdeletes');

    Route::resource('edulinks',EdulinksController::class);
    Route::delete('/edulinksbulkdelete',[EdulinksController::class,'bulkdeletes'])->name('edulinks.bulkdeletes');
    Route::get('/edulinks/download/{id}', [EdulinksController::class,'download'])->name('edulinks.download');


    Route::resource('enrolls',EnrollsController::class);
    Route::delete('/enrollsbulkdelete',[EnrollsController::class,'bulkdeletes'])->name('enrolls.bulkdeletes');

    Route::resource('genders',GendersController::class);
    Route::delete('/gendersbulkdelete',[GendersController::class,'bulkdeletes'])->name('genders.bulkdeletes');

    Route::resource('/leads',LeadsController::class); 
    Route::post('/leads/pipeline/{id}',[LeadsController::class,'converttostudent'])->name('leads.pipeline');

    Route::resource('leaves',LeavesController::class);
    Route::get('notify/markasread',[LeavesController::class,'markasread'])->name('leaves.markasread');
    Route::delete('/leavesbulkdelete',[LeavesController::class,'bulkdeletes'])->name('leaves.bulkdeletes');

    Route::post('/generateotps',[OtpsController::class,'generate']);
    Route::post('/verifyotps',[OtpsController::class,'verify']);

    Route::resource('packages',PackagesController::class);
    Route::post('packages/setpackage',[PackagesController::class,'setpackage'])->name('packages.setpackage');
    Route::delete('/packagesbulkdelete',[PackagesController::class,'bulkdeletes'])->name('packages.bulkdeletes');

    Route::resource('paymentmethods',PaymentmethodsController::class);
    Route::get('/paymentmethodsstatus', [PaymentmethodsController::class,'typestatus']);
    Route::delete('/paymentmethodsbulkdelete',[PaymentmethodsController::class,'bulkdeletes'])->name('paymentmethods.bulkdeletes');

    Route::resource('paymenttypes',PaymenttypesController::class);
    Route::delete('/paymenttypesbulkdelete',[PaymenttypesController::class,'bulkdeletes'])->name('paymenttypes.bulkdeletes');
    Route::get('/paymenttypesstatus', [PaymenttypesController::class,'typestatus']);

    Route::resource('plans',PlansController::class);

    Route::resource('pointtransfers',PointTransfersController::class);
    Route::post('/pointtransfers/transfer',[PointTransfersController::class,'transfer'])->name('pointtransfers.transfers');

   

    Route::middleware(['roles:Admin,Teacher'])->group(function(){
       // Route::resource('posts',PostsController::class);

        Route::get('posts/create',[PostsController::class,'create'])->name('posts.create');
        Route::post('posts',[PostsController::class,'store'])->name('posts.store');
        
        Route::get('posts/{post}/edit',[PostsController::class,'edit'])->name('posts.edit');
        Route::put('posts/{post}',[PostsController::class,'update'])->name('posts.update');
        Route::delete('posts/{post}',[PostsController::class,'delete'])->name('posts.destroy');


        Route::delete('/postsbulkdelete',[PostsController::class,'bulkdeletes'])->name('posts.bulkdeletes');
    });

    Route::get('posts',[PostsController::class,'index'])->middleware(['roles:Admin,Teacher,Student,Guest'])->name('posts.index');
    Route::get('posts/{post}',[PostsController::class,'show'])->middleware(['roles:Admin,Teacher,Student,Guest'])->name('posts.show'); // must be beneath create 
    Route::post('posts/{post}/like',[PostsLikeController::class,'like'])->middleware(['roles:Admin,Teacher,Student'])->name('post.like');
    Route::post('posts/{post}/unlike',[PostsLikeController::class,'unlike'])->middleware(['roles:Admin,Teacher,Student'])->name('post.unlike');

    Route::post('/postliveviewersinc/{post}',[PostLiveViewersController::class,'incrementviewer']); // here must be {post} , can't {id} cuz controller using (Post $post)
    Route::post('/postliveviewersdec/{post}',[PostLiveViewersController::class,'decrementviewer']);


    Route::post('/trackdurations',[PostViewDurationController::class,'trackduration']);

    Route::resource('permissions',PermissionsController::class);
    Route::get('/permissionsstatus',[PermissionsController::class,'typestatus']);
    Route::delete('/permissionsbulkdelete',[PermissionsController::class,'bulkdeletes'])->name('permissions.bulkdeletes');

    Route::resource('permissionroles',PermissionRolesController::class);
    Route::delete('/permissionrolesbulkdelete',[PermissionRolesController::class,'bulkdeletes'])->name('permissionroles.bulkdeletes');

    Route::resource('relatives',RelativesController::class);
    Route::get('/relativesstatus',[RelativesController::class,'typestatus']);
    Route::delete('/relativesbulkdelete',[RelativesController::class,'bulkdeletes'])->name('relatives.bulkdeletes');
    
    Route::resource('roles',RolesController::class);
    Route::get('/rolesstatus',[RolesController::class,'typestatus']);
    Route::delete('/rolesbulkdelete',[RolesController::class,'bulkdeletes'])->name('roles.bulkdeletes');

    Route::resource('students',StudentsController::class);
    Route::delete('/studentsbulkdelete',[StudentsController::class,'bulkdeletes'])->name('students.bulkdeletes');
    Route::post('compose/mailbox',[StudentsController::class,'mailbox'])->name('students.mailbox');
    Route::post('/students/quicksearch',[StudentsController::class,'quicksearch'])->name('students.quicksearch');
    Route::put('/students/{id}/profilepicture',[StudentsController::class,'updateprofilepicture'])->name('students.updateprofilepicture');

    Route::get('studentphones/delete/{id}', [StudentPhonesController::class,'destroy'])->name('studentphones.delete');

    Route::get('/subscribesexpired',[SubscriptionsController::class,'expired'])->name('subscriptions.expired');

    Route::resource('socialapplications',SocialapplicationsController::class);
    Route::get('/socialapplicationsstatus',[SocialapplicationsController::class,'typestatus']);
    Route::get('/socialapplicationsfetchalldata',[SocialapplicationsController::class,'fetchalldatas'])->name('socialapplications.fetchalldata');
    Route::delete('/socialapplicationsbulkdelete',[SocialapplicationsController::class,'bulkdeletes'])->name('socialapplications.bulkdeletes');

    Route::resource('stages',StagesController::class);
    Route::delete('/stagesbulkdelete',[StagesController::class,'bulkdeletes'])->name('stages.bulkdeletes');
    Route::get('/stagesstatus',[StagesController::class,'typestatus']);

    Route::resource('statuses',StatusesController::class);
    Route::delete('/statusesbulkdelete',[StatusesController::class,'bulkdeletes'])->name('statuses.bulkdeletes');

    Route::resource('tags',TagsController::class);
    Route::get('/tagsstatus',[TagsController::class,'typestatus']);
    Route::delete('/tagsbulkdelete',[TagsController::class,'bulkdeletes'])->name('tags.bulkdeletes');
    
    Route::resource('regions',RegionsController::class);
    Route::get('regionsstatus',[RegionsController::class,'typestatus']);
    Route::delete('/regionsbulkdelete',[RegionsController::class,'bulkdeletes'])->name('regions.bulkdeletes');
    Route::get('/filter/regions/{filter}',[RegionsController::class,'filterbycityid']);

    Route::resource('religions',ReligionsController::class);
    Route::get('religionsstatus',[ReligionsController::class,'typestatus']);
    Route::delete('/religionsbulkdelete',[ReligionsController::class,'bulkdeletes'])->name('religions.bulkdeletes');

    Route::resource('townships',TownshipsController::class);
    Route::get('townshipsstatus',[TownshipsController::class,'typestatus']);
    Route::delete('/townshipsbulkdelete',[TownshipsController::class,'bulkdeletes'])->name('townships.bulkdeletes');

    Route::resource('types',TypesController::class)->except('destroy');
    Route::get('/typesstatus',[Typescontroller::class,'typestatus']);
    Route::get('/typesdelete',[Typescontroller::class,'destroy'])->name('types.delete');
    Route::delete('/typesbulkdelete',[TypesController::class,'bulkdeletes'])->name('types.bulkdeletes');


    Route::post('users/{user}/follow',[UsersFollowerController::class,'follow'])->name('users.follow');
    Route::post('users/{user}/unfollow',[UsersFollowerController::class,'unfollow'])->name('users.unfollow');

    Route::resource('userpoints',UserPoinstsController::class);
    Route::post('/userpoints/verifystudent',[UserPoinstsController::class,'verifystudent'])->name('userpoint.verifystudent');
    Route::delete('/userpointsbulkdelete',[UserPoinstsController::class,'bulkdeletes'])->name('userpoints.bulkdeletes');

    
    Route::resource('warehouses',WarehousesController::class);
    Route::delete('/warehousesbulkdelete',[WarehousesController::class,'bulkdeletes'])->name('warehouses.bulkdeletes');

    // pusher test 
    Route::get('/pushers',function(){
        return view('pusher');
    });

    // pusher test by chat box 
    Route::get('/chatboxs', function(){
        return view('chatbox');
    });



    Route::post('/chatmessages',[ChatsController::class,'sendmessage']); 
   

});


Route::middleware(['auth','validate.subscription'])->group(function(){
    Route::resource('attendances',AttendancesController::class);
});





require __DIR__.'/auth.php';
