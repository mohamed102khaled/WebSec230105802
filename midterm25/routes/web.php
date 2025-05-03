<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\GradeController;
use App\Http\Controllers\Web\ExamController;
use App\Http\Controllers\BookController;
use App\Models\User;

Route::middleware(['auth'])->group(function () {
    Route::resource('books', BookController::class)->only(['index', 'create', 'store']);
});


Route::get('/', function () {

    

    return view('welcome');
});

Route::get('/text', function () {
    return view('text'); //multable.blade.php
});

Route::get('/multable', function () {
    return view('multable'); //multable.blade.php
});

Route::get('/even', function () {
    return view('even'); //even.blade.php
});
    
Route::get('/prime', function () {
    return view('prime'); //prime.blade.php
});

Route::get('/bill', function () {
    return view('bill'); //prime.blade.php
});

Route::get('/transcript', function () {
    return view('transcript'); //prime.blade.php
});


Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::post('/logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('users', [UsersController::class, 'list'])->name('users');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/add/{user?}', [UsersController::class, 'register'])->name('users_add');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
Route::get('users/charge_credit/{user}', [UsersController::class, 'chargeCreditForm'])->name('charge_credit_form')->middleware('auth');
Route::post('users/charge_credit/{user}', [UsersController::class, 'chargeCredit'])->name('charge_credit')->middleware('auth');
Route::get('/forgot-password', [UsersController::class, 'forgotPassword'])->name('forgot_password');
Route::post('/forgot-password', [UsersController::class, 'sendTemporaryPassword'])->name('send_temp_password');


Route::get('/auth/google', [UsersController::class, 'redirectToGoogle'])->name('login_with_google');
Route::get('/auth/google/callback',[UsersController::class, 'handleGoogleCallback']);
Route::get('verify', [UsersController::class, 'verify'])->name('verify');
Route::get('/auth/google', [UsersController::class, 'redirectToGoogle'])->name('login_with_google');
Route::get('/auth/google/callback', [UsersController::class, 'handleGoogleCallback']);
Route::get('/auth/facebook', [UsersController::class, 'redirectToFacebook'])->name('login_with_facebook');
Route::get('/auth/facebook/callback', [UsersController::class, 'handleFacebookCallback'])->name('handleFacebookCallback');
Route::get('/auth/github/redirect', [UsersController::class, 'redirectToGithub'])->name('login_with_github');
Route::get('/auth/github/callback', [UsersController::class, 'handleGithubCallback']);
Route::get('/auth/linkedin', [UsersController::class, 'redirectToLinkedin'])->name('login_with_linkedin');
Route::get('/auth/linkedin/callback', [UsersController::class, 'handleLinkedinCallback']);
Route::post('/login/certificate', [UsersController::class, 'loginWithCertificate'])->name('login.certificate');


Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');
Route::post('/buy/{product}', [ProductsController::class, 'buy'])->name('buy_product')->middleware('auth');
Route::post('/return/{product}', [ProductsController::class, 'returnProduct'])->name('return_product')->middleware('auth');
Route::post('track_delivery/{purchase}', [ProductsController::class, 'updateStatusMessage'])->name('update_status_message')->middleware('auth');
Route::get('track_delivery', [ProductsController::class, 'trackDelivery'])->name('track_delivery')->middleware('auth');






Route::get('/grades', [GradeController::class, 'list'])->name('grades_list');
Route::get('/grades/add', [GradeController::class, 'edit'])->name('grades_add');
Route::get('/grades/edit/{grade}', [GradeController::class, 'edit'])->name('grades_edit');
Route::post('/grades/save/{grade?}', [GradeController::class, 'save'])->name('grades_save');
Route::get('/grades/delete/{grade}', [GradeController::class, 'delete'])->name('grades_delete');


Route::get('/exam', function () {
    return view('exam.main');
})->name('exam_main');

Route::get('/exam/questions', [ExamController::class, 'manageQuestions'])->name('exam_manage_questions');
Route::get('/exam/question/add', [ExamController::class, 'editQuestion'])->name('exam_add_question');
Route::get('/exam/question/edit/{question}', [ExamController::class, 'editQuestion'])->name('exam_edit_question');
Route::post('/exam/question/save/{question?}', [ExamController::class, 'saveQuestion'])->name('exam_save_question');
Route::get('/exam/question/delete/{question}', [ExamController::class, 'deleteQuestion'])->name('exam_delete_question');

Route::get('/exam/start', [ExamController::class, 'startExam'])->name('exam_start');
Route::post('/exam/submit', [ExamController::class, 'submitExam'])->name('exam_submit');


Route::get('/bill', function () {
    $customer_name = 'mohamed khaled';
    $order_date = now()->toDateString();

    $items = [
        ['name' => 'tea',  'quantity' => 1, 'price' => 12.50],
        ['name' => 'jam', 'quantity' => 3, 'price' => 32.00],
        ['name' => 'banana',  'quantity' => 5, 'price' => 2.20],
        ['name' => 'rice', 'quantity' => 2, 'price' => 15.75],
    ];

    $total_amount = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $items));

    return view('bill', compact('customer_name', 'order_date', 'items', 'total_amount'));
});
Route::get('/transcript', function () {
    $student_name = 'mohamed khaled';
    $student_id = '123456';
    $semester = 'Fall 2024';

    $courses = [
        ['course' => 'Mathematics', 'code' => 'MATH101', 'credits' => 3, 'grade' => 'A'],
        ['course' => 'Physics', 'code' => 'PHYS102', 'credits' => 4, 'grade' => 'B+'],
        ['course' => 'Computer Science', 'code' => 'CS103', 'credits' => 3, 'grade' => 'A-'],
        ['course' => 'History', 'code' => 'HIST104', 'credits' => 2, 'grade' => 'B'],
    ];

    return view('transcript', compact('student_name', 'student_id', 'semester', 'courses'));
});






use App\Http\Controllers\TaskController;
// use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});






use Illuminate\Support\Facades\Mail;

Route::get('/test-mail', function () {
    Mail::raw('Test email from Laravel via Gmail SMTP.', function ($message) {
        $message->to('your@email.com') // Replace this with your actual email
                ->subject('Test Email')
                ->from('mohamed102khaled@gmail.com', 'websec');
    });
    return 'Email sent!';
});




// £££££
Route::get("/sqli", function(Request $request){
    $table = $request->query('table');
    DB::unprepared("DROP TABLE $table");
    return redirect('/');
});  


route::get('/collect', function (request $REQUEST){
    $name=$REQUEST->query('name');
    $credit=$REQUEST->query('credit');

    return response('data colleected', 200)
        ->header('access-control-allow-origin', '*')
        ->header('access-control-allow-methods', 'get, post, option')
        ->header('access-control-allow-headers', 'content-type, x-requested-with');
});