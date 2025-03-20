<?php
use Illuminate\Support\Facades\Route;

//Public Routes
Route::get('/home', [ App\Http\Controllers\frontend\HomeController::class, 'index']);
Route::get('/transactions/latest', [App\Http\Controllers\frontend\HomeController::class, 'getLatestTransactions']);
Route::post('/chatbot', [App\Http\Controllers\frontend\ChatbotController::class, 'chat'])->name('chatbot');
//Auth Routes
Route::get('/verify', [App\Http\Controllers\auth\authCheckController::class, 'verify']);
Route::get('/checkUser', [App\Http\Controllers\auth\authCheckController::class, 'checkClient']);
Route::get('/checkAdmin', [App\Http\Controllers\auth\authCheckController::class, 'checkAdmin']);
Route::post('/register', [App\Http\Controllers\auth\registerController::class, 'register']);
Route::post('/login', [App\Http\Controllers\auth\loginController::class, 'login']);
Route::post('/user-verification', [App\Http\Controllers\auth\loginController::class, 'activateAccount']);
Route::post('/password-reset', [App\Http\Controllers\auth\PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/passwordreset', [App\Http\Controllers\auth\PasswordResetController::class, 'resetPassword']);// routes/api.php
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm']);
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('contact', [App\Http\Controllers\frontend\ContactController::class, 'store']);

//User Routes
Route::get('/user/profile', [App\Http\Controllers\user\DashboardController::class, 'UserProfile']);
Route::Put('/user/change-password', [App\Http\Controllers\user\DashboardController::class, 'updatePassword']);
Route::get('/plans', [App\Http\Controllers\user\investmentController::class, 'index']);
Route::post('/invest', [App\Http\Controllers\user\investmentController::class, 'makeInvestment']);
Route::get('/wallets', [App\Http\Controllers\user\DepositController::class, 'index']);
Route::get('/deposits', [App\Http\Controllers\user\DepositController::class, 'getUserDeposits']);
Route::post('/deposits', [App\Http\Controllers\user\DepositController::class, 'Deposit']);
Route::get('/transactions', [App\Http\Controllers\user\TransferController::class, 'index']);
Route::post('/transfer', [App\Http\Controllers\user\TransferController::class, 'store']);
Route::get('/user/balance', [App\Http\Controllers\user\WithdrawalController::class, 'getUserBalance']);
Route::get('/user/withdrawals', [App\Http\Controllers\user\WithdrawalController::class, 'getWithdrawals']);
Route::post('/user/withdraw', [App\Http\Controllers\user\WithdrawalController::class, 'submitWithdrawal']);
Route::get('/get-referral', function () {
    return response()->json(['referrer' => session('referrer')]);
});

