<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Dashboard\DashboardController;

Route::get('/', function () {
    return view('home.homepage');
});

Route::get('/about', function () {
    return view('home.about');
});

Route::get('/questions', function () {
    return view('home.questions');
});

Route::get('/contact', function () {
    return view('home.contact');
});

Route::get('/faq', function () {
    return view('home.faq');
});

Route::get('/insights', function () {
    return view('home.insights');
});

Route::get('/process', function () {
    return view('home.process');
});

Route::get('/deposit-withdraw', function () {
    return view('home.deposit');
});

Route::get('/privacy', function () {
    return view('home.privacy');
});

Route::get('/terms', function () {
    return view('home.terms');
});

Route::get('/refund', function () {
    return view('home.refund');
});

Route::get('/forex', function () {
    return view('home.forex');
});

Route::get('/cfds', function () {
    return view('home.cfds');
});

Route::get('/bonds', function () {
    return view('home.bonds');
});

Route::get('/etfs', function () {
    return view('home.etfs');
});

Route::get('/stocks', function () {
    return view('home.stocks');
});

Route::get('/copy', function () {
    return view('home.copy');
});

Route::get('/bitcoin-trading', function () {
    return view('home.bitcoin-trading');
});

Route::get('/cryptocurrency', function () {
    return view('home.cryptocurrency');
});

Route::get('/binary', function () {
    return view('home.binary');
});

Route::get('/partner', function () {
    return view('home.partner');
});




// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Password reset
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot.password.form');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('forgot.password.submit');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset.password.submit');
});

// Email verification resend (auth, throttled)
Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Dashboard (authenticated users) ───────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Home
    Route::get('/dashboard',          [DashboardController::class, 'index'])->name('dashboard');

    // Pages
    Route::get('/forex',              [DashboardController::class, 'forex'])->name('forex');
    Route::get('/dashboard/pricing',  [DashboardController::class, 'pricing'])->name('pricing');
    Route::get('/dashboard/plans',    [DashboardController::class, 'plans'])->name('plans.page');
    Route::get('/mining-plans',       [DashboardController::class, 'miningPlans'])->name('miningplans');
    Route::get('/mining',             [DashboardController::class, 'mining'])->name('mining');
    Route::get('/traders',            [DashboardController::class, 'traders'])->name('traders');
    Route::get('/binary',             [DashboardController::class, 'binary'])->name('binary');
    Route::get('/dashboard/stocks',   [DashboardController::class, 'stocks'])->name('stocks.dashboard');
    Route::get('/crypto',             [DashboardController::class, 'crypto'])->name('crypto');
    Route::get('/wallet',             [DashboardController::class, 'wallet'])->name('wallet');
    Route::get('/copy-trading',       [DashboardController::class, 'copy'])->name('copy');
    Route::get('/crypto-buy',         [DashboardController::class, 'cryptoBuy'])->name('crypto.buy');
    Route::get('/bot',                [DashboardController::class, 'bot'])->name('bot');
    Route::get('/profile',            [DashboardController::class, 'profile'])->name('profile');
    Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::get('/profile-detail',     [DashboardController::class, 'profileDetail'])->name('profiledetail');
    Route::get('/dashboard/notification', [DashboardController::class, 'notification'])->name('notification');
    Route::get('/address',            [DashboardController::class, 'address'])->name('address');
    Route::get('/verification',       [DashboardController::class, 'verification'])->name('verification');
    Route::get('/verify-account',     [DashboardController::class, 'identityVerify'])->name('identityverify');
    Route::get('/markets',            [DashboardController::class, 'markets'])->name('markets');
    Route::get('/update-photo',       [DashboardController::class, 'updatePhoto'])->name('update.photo');
    Route::get('/update-password',    [DashboardController::class, 'updateUserPassword'])->name('update.password');
    Route::get('/support',            [DashboardController::class, 'support'])->name('support');
    Route::get('/bonus',              [DashboardController::class, 'bonus'])->name('bonus');
    Route::get('/referral',           [DashboardController::class, 'referral'])->name('referral');
    Route::get('/refer-user',         [DashboardController::class, 'referUser'])->name('referuser');
    Route::get('/trading-room',       [DashboardController::class, 'tradingRoom'])->name('tradingroom');
    Route::get('/watchlist',          [DashboardController::class, 'watchlist'])->name('watchlist');
    Route::get('/email',              [DashboardController::class, 'email'])->name('email');
    Route::get('/buy-plan',           [DashboardController::class, 'buyPlanPage'])->name('buyplan');
    Route::get('/investment-history', [DashboardController::class, 'investmentHistory'])->name('investmentHistory');
    Route::get('/trading-history',    [DashboardController::class, 'tradingHistory'])->name('tradinghistory');
    Route::get('/earnings',           [DashboardController::class, 'earnings'])->name('earnings');
    Route::get('/withdrawals',        [DashboardController::class, 'withdrawals'])->name('withdrawals.page');
    Route::get('/withdrawal-select',  [DashboardController::class, 'withdrawalSelect'])->name('withdrawalselect');
    Route::get('/bank',               [DashboardController::class, 'bank'])->name('bank');
    Route::get('/paypal',             [DashboardController::class, 'paypal'])->name('paypal');
    Route::get('/cashapp',            [DashboardController::class, 'cashapp'])->name('cashapp');
    Route::get('/withdrawal-list',    [DashboardController::class, 'withdrawalList'])->name('withdrawallist');
    Route::get('/mining-history',     [DashboardController::class, 'miningHistory'])->name('mininghistory');
    Route::get('/account-history',    [DashboardController::class, 'accountHistory'])->name('accounthistory');
    Route::get('/all-notifications',  [DashboardController::class, 'allNotifications'])->name('all.notifications');
    Route::get('/next-details',       [DashboardController::class, 'nextDetails'])->name('next.details');
    Route::get('/photo',              [DashboardController::class, 'photo'])->name('photo');

    // Deposit flow
    Route::get('/deposit',            [DashboardController::class, 'userDeposit'])->name('deposit');
    Route::get('/get-deposit',        [DashboardController::class, 'getDeposit'])->name('get.deposit');
    Route::get('/payment',            [DashboardController::class, 'getAllPayment'])->name('get.payment');
    Route::post('/make-deposit',      [DashboardController::class, 'makeDeposit'])->name('make.deposit');
    Route::get('/get-payment',        [DashboardController::class, 'getPayment'])->name('choose.payment');

    // Withdrawal flow
    Route::get('/get-withdrawal',         [DashboardController::class, 'getWithdrawal'])->name('get.withdrawal');
    Route::post('/make-withdrawal',       [DashboardController::class, 'makeWithdrawal'])->name('make.withdrawal');
    Route::post('/make-crypto-withdrawal',[DashboardController::class, 'makeCryptoWithdrawal'])->name('make.crypto.withdrawal');
    Route::post('/make-paypal-withdrawal',[DashboardController::class, 'makePaypalWithdrawal'])->name('make.paypal.withdrawal');
    Route::post('/make-cashapp-withdrawal',[DashboardController::class, 'makeCashappWithdrawal'])->name('make.cashapp.withdrawal');

    // Withdrawal code pages
    Route::get('/withdrawal-code',        [DashboardController::class, 'showCodePage'])->name('withdrawal.code');
    Route::get('/withdrawal-code-bank',   [DashboardController::class, 'showBankCodePage'])->name('withdrawal.code.bank');
    Route::post('/verify-withdrawal-code',     [DashboardController::class, 'verifyWithdrawalCode'])->name('verify.withdrawal.code');
    Route::post('/verify-bank-withdrawal-code',[DashboardController::class, 'verifyBankWithdrawalCode'])->name('verify.bank.withdrawal.code');
    Route::get('/withdrawal-tax',         [DashboardController::class, 'withdrawalTaxPage'])->name('withdrawal.tax.codepage');
    Route::post('/withdrawal-tax-code',   [DashboardController::class, 'withdrawalTaxCode'])->name('withdrawal.tax.code');

    // Plans
    Route::post('/buy-plans',     [DashboardController::class, 'buyPlans'])->name('buy.plans');

    // Profile & account actions
    Route::post('/upload-kyc',        [DashboardController::class, 'uploadKyc'])->name('upload.kyc');
    Route::post('/upload-profile',    [DashboardController::class, 'uploadProfile'])->name('upload.profile');
    Route::post('/activate-bot',      [DashboardController::class, 'activateBot'])->name('activate.bot');
    Route::post('/profile-update',    [DashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::post('/step2',             [DashboardController::class, 'step2'])->name('step2');
    Route::post('/step3',             [DashboardController::class, 'step3'])->name('step3');
    Route::post('/update-password',   [DashboardController::class, 'updatePassword'])->name('password.update');
    Route::post('/update-email',      [DashboardController::class, 'updateEmail'])->name('email.update');
    Route::post('/mark-all-read',     [DashboardController::class, 'markAllRead'])->name('mark.all.read');
    Route::post('/dashboard/logout',  [DashboardController::class, 'logout'])->name('dashboard.logout');

    // Route name aliases used in views
    Route::get('/all-notifications',      [DashboardController::class, 'allNotifications'])->name('user.notifications');
    Route::post('/mark-all-read-ajax',    [DashboardController::class, 'markAllRead'])->name('user.notifications.markAllRead');
    Route::post('/update-address',        [DashboardController::class, 'profileUpdate'])->name('update-password');
    Route::post('/upload-picture',        [DashboardController::class, 'uploadProfile'])->name('upload_picture');
    Route::get('/do-logout',              [DashboardController::class, 'logout'])->name('logout.perform');
    Route::post('/verify-pin',            [DashboardController::class, 'verifyPin'])->name('code');
});