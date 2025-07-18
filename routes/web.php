<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\TransferController;
use App\Http\Middleware\CheckStatus;

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

Route::get('/', [AuthController::class,'showLandingpage'])->name('Landingpage');
Route::get('/Privacy', [AuthController::class,'Privacy_policy'])->name('Privacy');
Route::get('/terms', [AuthController::class,'Terms_condition'])->name('terms');
Route::get('/login', [AuthController::class,'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class,'showLoginForm'])->name('login');

Route::get('/depositAddress', [TestController::class,'depositAddress'])->name('depositAddress');
Route::get('/getBalance', [TestController::class,'getBalance'])->name('getBalance');


Route::post('/send-email', [AuthController::class, 'sendEmail'])->name('send.email');

Route::middleware('guest')->post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register/{sponsor?}', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register/{sponsor?}', [AuthController::class, 'register']);
Route::get('forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('forget-password');
Route::post('forget-password', [AuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [AuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::get('logout', [AuthController::class,'logout'])->middleware('auth')->name('logout');
Route::get('/register-confirm', [AuthController::class, 'showRegisterFormConfirm'])->name('register-confirm');
Route::post('/register-confirm', [AuthController::class, 'postRegisterFormConfirm'])->name('register-confirm');
Route::post('/resend-confirm-otp', [AuthController::class, 'resendConfirmOTP'])->name('resend.confirm.otp');

Route::middleware(['auth', CheckStatus::class])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/change-password', [HomeController::class, 'change_password'])->name('password.change');
    Route::post('/update-password', [HomeController::class, 'changePassword'])->name('password.update');
    Route::get('profile', [HomeController::class, 'profile'])->name('users.edit');
    Route::post('/update-users', [HomeController::class, 'update'])->name('users.update');

    // web.php or api.php (depending on your preference)
    Route::post('/total-investment', [UsersController::class, 'getTotalInvestment'])->name('user.total-investment');
    Route::post('/total-level-income', [UsersController::class, 'getTotalLevelIncome'])->name('user.total-level-income');
    Route::post('/total-deposit', [UsersController::class, 'getTotalDeposit'])->name('user.getTotalDeposit');


    Route::match(["get","post"], 'buyPackage', [UsersController::class, 'buyPackage'])->name('buy.package');
    Route::match(["get", "post"], 'transactions', [UsersController::class, 'transactions'])->name('user.transactions');
    Route::match(["get"], 'teams', [UsersController::class, 'teams'])->name('user.teams');
    Route::post('getTransactions', [UsersController::class, 'getTransactions'])->name('user.getTransactions');
    Route::post('getTeams', [UsersController::class, 'getTeams'])->name('user.getTeams');
    Route::match(["get","post"], 'usdtPayment', [UsersController::class, 'usdtPayment'])->name('deposit.usdt');
    Route::match(["get","post"], 'uscPayment', [UsersController::class, 'uscPayment'])->name('deposit.sri');
    Route::post('depositRecords', [UsersController::class, 'getDeposits'])->name('deposit.records');
    Route::post('getPurchase', [UsersController::class, 'getPurchaseHistory'])->name('buy.getPurchase');
    
    Route::match(["get","post"], 'internalTransfer', [TransferController::class, 'internalTransfer'])->name('user.internalTransfer');
    Route::match(["post"], 'internalTransferHistory', [TransferController::class, 'internalTransferHistory'])->name('user.internalTransferHistory');

    Route::match(["get","post"], 'walletTransfer', [TransferController::class, 'walletTransfer'])->name('user.walletTransfer');
    Route::match(["post"], 'walletTransferHistory', [TransferController::class, 'walletTransferHistory'])->name('user.walletTransferHistory');
    Route::get('/withdraw-response/{currency}/{status}', [WithdrawController::class, 'withdrawResponse'])->name('withdrawResponse');

    Route::match(["get","post"], 'withdraw', [WithdrawController::class, 'index'])->name('user.withdraw');
    Route::match(["post"], 'withdrawrequest', [WithdrawController::class, 'generateWithdrawRequest'])->name('user.withdrawrequest');
    Route::post('/getWithdrawHistory', [WithdrawController::class, 'getWithdrawHistory'])->name('user.getWithdrawHistory');

});
Route::get('/setting/usc/{status}', [HomeController::class, 'updateSetting'])->name('updateSetting');
Route::post('/resend-admin-login-otp', [AuthController::class, 'resendAdminLoginOTP'])->name('resend.admin.login.otp');
Route::post('/admin-login-confirm', [AuthController::class, 'adminLoginConfirm'])->name('admin.login.confirm');
Route::get('/impersonate/leave', [App\Http\Controllers\Admin\ImpersonateController::class, 'leaveImpersonation'])->name('admin.impersonate.leave');
        
Route::prefix('admin')->group(function () {
    Route::get('/admin-otp', [App\Http\Controllers\Admin\DashboardController::class, 'loginOTP'])->name('admin.loginOTP');
    Route::get('/logs', [App\Http\Controllers\Admin\DashboardController::class, 'logs'])->name('admin.logs');
    Route::get('/users-logs', [App\Http\Controllers\Admin\DashboardController::class, 'userlogs'])->name('users.logs');
    Route::group(['middleware' => ['auth', 'admin']], function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/impersonate/leave', [App\Http\Controllers\Admin\ImpersonateController::class, 'leaveImpersonation'])->name('admin.impersonate.leave');
        Route::get('/impersonate/{user}', [App\Http\Controllers\Admin\ImpersonateController::class, 'impersonate'])->name('admin.impersonate');
        Route::prefix('users')->group(function () {
            Route::get('/index/{flag?}', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
            Route::get('/status_update', [App\Http\Controllers\Admin\UserController::class, 'status_update'])->name('users.status_update');
            Route::get('/verify_status_update', [App\Http\Controllers\Admin\UserController::class, 'verify_status_update'])->name('users.verify_status_update');
            Route::get('/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
            Route::post('/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('user.edit');
            Route::post('/update/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
            Route::post('/destroy', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

            Route::get('/info/{id}', [App\Http\Controllers\Admin\UserController::class, 'view'])->name('users.info');
            Route::get('/user-details/{username}', [App\Http\Controllers\Admin\UserController::class, 'viewWithEmail'])->name('users.details');

            // Route::get('/team/{id}', [App\Http\Controllers\Admin\UserController::class, 'team'])->name('users.team');
            Route::match(['get', 'post'], '/team/{id}', [App\Http\Controllers\Admin\UserController::class, 'team'])->name('users.team');

            Route::get('/transactions/{id}', [App\Http\Controllers\Admin\UserController::class, 'transactions'])->name('users.transactions');
            Route::post('/transactions/{id}', [App\Http\Controllers\Admin\UserController::class, 'transactions'])->name('users.transactions');
            // Route::match(['get', 'post'], '/transactions/{id}', [App\Http\Controllers\Admin\UserController::class, 'transactions'])->name('users.transactions');

            Route::post('/view-balance', [App\Http\Controllers\Admin\UserController::class, 'viewUserBalanceAjax'])->name('view-balance');
        });

        // Route::get('update-deposit-to-from-address', [App\Http\Controllers\Admin\DashboardController::class, 'update_deposit_from_address'])->name('update-deposit-from-address');

        Route::prefix('swap')->group(function () {
            Route::get('/index', [App\Http\Controllers\Admin\SwapController::class, 'index'])->name('swap.index');
            Route::post('/status_update', [App\Http\Controllers\Admin\SwapController::class, 'status_update'])->name('swap.status_update');
            Route::get('/create', [App\Http\Controllers\Admin\SwapController::class, 'create'])->name('swap.create');
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\SwapController::class, 'edit'])->name('swap.edit');
            Route::post('/update/{id}', [App\Http\Controllers\Admin\SwapController::class, 'update'])->name('swap.update');
            Route::post('/request_accept', [App\Http\Controllers\Admin\SwapController::class, 'request_accept'])->name('swap.request_accept');
            Route::post('/request_reject', [App\Http\Controllers\Admin\SwapController::class, 'request_reject'])->name('swap.request_reject');
            Route::get('/export-report-csv', [App\Http\Controllers\Admin\SwapController::class, 'export_csv'])->name('swap.export_csv');
            Route::post('/view_transid', [App\Http\Controllers\Admin\SwapController::class, 'view_transid'])->name('swap.view_transid');
        });

        Route::prefix('settings')->group(function () {
            Route::get('/file-manager/index', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('filemanager.index');
            Route::get('/index', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
            Route::get('/status_update', [App\Http\Controllers\Admin\SettingController::class, 'status_update'])->name('settings.status_update');
            Route::get('/create', [App\Http\Controllers\Admin\SettingController::class, 'create'])->name('settings.create');
            Route::post('/store', [App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store');
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('settings.edit');
            Route::post('/update', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
            Route::post('/destroy', [App\Http\Controllers\Admin\SettingController::class, 'destroy'])->name('settings.destroy');
        });

        Route::prefix('deposits')->group(function () {
            Route::get('/index/{flag?}', [App\Http\Controllers\Admin\DepositController::class, 'index'])->name('deposits.index');
            Route::get('/status_update', [App\Http\Controllers\Admin\DepositController::class, 'status_update'])->name('deposits.status_update');
            Route::get('/create', [App\Http\Controllers\Admin\DepositController::class, 'create'])->name('deposits.create');
            Route::post('/store', [App\Http\Controllers\Admin\DepositController::class, 'store'])->name('deposits.store');
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\DepositController::class, 'edit'])->name('deposits.edit');
            Route::post('/update/{id}', [App\Http\Controllers\Admin\DepositController::class, 'update'])->name('deposits.update');
            Route::post('/destroy', [App\Http\Controllers\Admin\DepositController::class, 'destroy'])->name('deposits.destroy');
        });

        Route::prefix('invoices')->group(function () {
            Route::get('/index/{flag?}', [App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('invoices.index');
            Route::get('/status_update', [App\Http\Controllers\Admin\InvoiceController::class, 'status_update'])->name('invoices.status_update');
            Route::get('/create', [App\Http\Controllers\Admin\InvoiceController::class, 'create'])->name('invoices.create');
            Route::post('/store', [App\Http\Controllers\Admin\InvoiceController::class, 'store'])->name('invoices.store');
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'edit'])->name('invoices.edit');
            Route::post('/update/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'update'])->name('invoices.update');
            Route::post('/destroy', [App\Http\Controllers\Admin\InvoiceController::class, 'destroy'])->name('invoices.destroy');
            Route::post('syncBuyTransactions', [App\Http\Controllers\Admin\InvoiceController::class, 'syncBuyTransactions'])->name('invoices.sync');
        });

        Route::prefix('transfer')->group(function () {
            Route::get('/history', [App\Http\Controllers\Admin\TransferController::class, 'history'])->name('transfer.history');
        });

        Route::prefix('withdraw')->group(function () {
            Route::get('/index/{flag?}', [App\Http\Controllers\Admin\WithdrawController::class, 'index'])->name('withdraw.index');
            Route::post('/allWithdrawals', [App\Http\Controllers\Admin\WithdrawController::class, 'allWithdrawals'])->name('withdraw.allWithdrawals');
            
        });

        Route::prefix('transactions')->group(function () {
            Route::get('/index/{flag?}', [App\Http\Controllers\Admin\TransactionsController::class, 'index'])->name('transactions.index');
            Route::post('/history', [App\Http\Controllers\Admin\TransactionsController::class, 'history'])->name('transactions.history');
        });
    });
});