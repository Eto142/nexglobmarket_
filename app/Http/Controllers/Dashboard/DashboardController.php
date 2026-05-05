<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Debitprofit;
use App\Models\Deposit;
use App\Models\Earning;
use App\Models\Kyc;
use App\Models\Notification;
use App\Models\Plan;
use App\Models\Profit;
use App\Models\Refferal;
use App\Models\Traders;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    // ─────────────────────────────────────────────
    // Private helper – returns common balance data
    // ─────────────────────────────────────────────
    private function balanceData(): array
    {
        $uid = Auth::id();

        $credit = Transaction::where('user_id', $uid)->where('status', '1')->sum('credit');
        $debit  = Transaction::where('user_id', $uid)->where('status', '1')->sum('debit');

        $deposit     = Deposit::where('user_id', $uid)->where('status', '1')->sum('amount');
        $withdrawal  = Withdrawal::where('user_id', $uid)->sum('amount');
        $addprofit   = Profit::where('user_id', $uid)->sum('amount');
        $debitprofit = Debitprofit::where('user_id', $uid)->sum('amount');
        $profit      = $addprofit - $debitprofit;
        $earning     = Earning::where('user_id', $uid)->sum('amount');
        $referral    = Refferal::where('user_id', $uid)->sum('amount');
        $balance     = $profit + $deposit + $earning + $referral - $withdrawal;

        return [
            'credit'       => $credit,
            'debit'        => $debit,
            'user_balance' => $credit - $debit,
            'deposit'      => $deposit,
            'withdrawal'   => $withdrawal,
            'profit'       => $profit,
            'addprofit'    => $addprofit,
            'debitprofit'  => $debitprofit,
            'earning'      => $earning,
            'referral'     => $referral,
            'balance'      => $balance,
        ];
    }

    // ─────────────────────────────────────────────
    // Page: Dashboard Home
    // ─────────────────────────────────────────────
    public function index()
    {
        $data = $this->balanceData();
        $uid  = Auth::id();

        $data['deposithistory']    = Deposit::where('user_id', $uid)->orderBy('id', 'desc')->get();
        $data['profithistory']     = Profit::where('user_id', $uid)->orderBy('id', 'desc')->get();
        $data['withdrawalhistory'] = Withdrawal::where('user_id', $uid)->orderBy('id', 'desc')->get();

        return view('dashboard.home', $data);
    }

    // ─────────────────────────────────────────────
    // Page views (display only)
    // ─────────────────────────────────────────────
    public function forex()
    {
        return view('dashboard.forex', $this->balanceData());
    }

    public function pricing()
    {
        return view('dashboard.pricing', $this->balanceData());
    }

    public function plans()
    {
        return view('dashboard.plans', $this->balanceData());
    }

    public function miningPlans()
    {
        return view('dashboard.miningplans', $this->balanceData());
    }

    public function mining()
    {
        return view('dashboard.mining', $this->balanceData());
    }

    public function traders()
    {
        $data            = $this->balanceData();
        $data['traders'] = Traders::all();
        return view('dashboard.traders', $data);
    }

    public function binary()
    {
        return view('dashboard.binary', $this->balanceData());
    }

    public function stocks()
    {
        return view('dashboard.stocks', $this->balanceData());
    }

    public function crypto()
    {
        return view('dashboard.crypto', $this->balanceData());
    }

    public function wallet()
    {
        return view('dashboard.wallet', $this->balanceData());
    }

    public function copy()
    {
        $data            = $this->balanceData();
        $data['traders'] = Traders::all();
        return view('dashboard.copy', $data);
    }

    public function cryptoBuy()
    {
        return view('dashboard.crypto_buy', $this->balanceData());
    }

    public function bot()
    {
        return view('dashboard.bot', $this->balanceData());
    }

    public function profile()
    {
        return view('dashboard.profile');
    }

    public function settings()
    {
        return view('dashboard.settings', $this->balanceData());
    }

    public function profileDetail()
    {
        return view('dashboard.profiledetail');
    }

    public function notification()
    {
        return view('dashboard.notification');
    }

    public function address()
    {
        return view('dashboard.address');
    }

    public function verification()
    {
        return view('dashboard.verification');
    }

    public function identityVerify()
    {
        $data              = $this->balanceData();
        $data['kycStatus'] = Kyc::where('user_id', Auth::id())->get();
        $data['kyc']       = $data['kycStatus'];
        return view('dashboard.identityverify', $data)
            ->with('status', 'Documents updated successfully, please wait for approval');
    }

    public function markets()
    {
        return view('dashboard.market');
    }

    public function photo()
    {
        return view('dashboard.photo', $this->balanceData());
    }

    public function support()
    {
        return view('dashboard.support', $this->balanceData());
    }

    public function bonus()
    {
        return view('dashboard.bonus', $this->balanceData());
    }

    public function referral()
    {
        return view('dashboard.referral', $this->balanceData());
    }

    public function referUser()
    {
        return view('dashboard.referuser', $this->balanceData());
    }

    public function tradingRoom()
    {
        return view('dashboard.tradingroom', $this->balanceData());
    }

    public function watchlist()
    {
        return view('dashboard.watchlist', $this->balanceData());
    }

    public function email()
    {
        return view('dashboard.email', $this->balanceData());
    }

    public function updatePhoto()
    {
        return view('dashboard.updatephoto', $this->balanceData());
    }

    public function updateUserPassword()
    {
        return view('dashboard.updatepassword', $this->balanceData());
    }

    public function buyPlanPage()
    {
        return view('dashboard.buy-plan');
    }

    public function investmentHistory()
    {
        return view('dashboard.investmentHistory');
    }

    public function tradingHistory()
    {
        return view('dashboard.tradinghistory', $this->balanceData());
    }

    public function earnings()
    {
        return view('dashboard.earnings', $this->balanceData());
    }

    public function withdrawals()
    {
        return view('dashboard.withdrawals', $this->balanceData());
    }

    public function withdrawalSelect()
    {
        return view('dashboard.withdrawalselect', $this->balanceData());
    }

    public function bank()
    {
        return view('dashboard.bank', $this->balanceData());
    }

    public function paypal()
    {
        return view('dashboard.paypal', $this->balanceData());
    }

    public function cashapp()
    {
        return view('dashboard.cashapp', $this->balanceData());
    }

    public function withdrawalList()
    {
        $data               = $this->balanceData();
        $uid                = Auth::id();
        $data['deposit']    = Deposit::where('user_id', $uid)->orderBy('id', 'desc')->get();
        $data['withdrawal'] = Withdrawal::where('user_id', $uid)->orderBy('id', 'desc')->get();
        $data['earning']    = Earning::where('user_id', $uid)->orderBy('id', 'desc')->get();
        return view('dashboard.withdrawallist', $data);
    }

    public function miningHistory()
    {
        $data               = $this->balanceData();
        $uid                = Auth::id();
        $data['deposit']    = Deposit::where('user_id', $uid)->orderBy('id', 'desc')->get();
        $data['withdrawal'] = Withdrawal::where('user_id', $uid)->orderBy('id', 'desc')->get();
        $data['earning']    = Earning::where('user_id', $uid)->orderBy('id', 'desc')->get();
        $data['mining']     = Deposit::where('user_id', $uid)
            ->where('trading_name', 'like', '%Mining%')
            ->orderBy('id', 'desc')
            ->get();
        return view('dashboard.mininghistory', $data);
    }

    public function accountHistory()
    {
        $data               = $this->balanceData();
        $uid                = Auth::id();
        $data['deposit']    = Deposit::where('user_id', $uid)->orderBy('id', 'desc')->get();
        $data['withdrawal'] = Withdrawal::where('user_id', $uid)->orderBy('id', 'desc')->get();
        $data['earning']    = Earning::where('user_id', $uid)->orderBy('id', 'desc')->get();
        return view('dashboard.accounthistory', $data);
    }

    public function allNotifications()
    {
        $data                  = $this->balanceData();
        $data['notifications'] = Notification::where('user_id', Auth::id())->latest()->get();
        return view('dashboard.all-notifications', $data);
    }

    // ─────────────────────────────────────────────
    // Deposit flow
    // ─────────────────────────────────────────────
    public function userDeposit()
    {
        $data            = $this->balanceData();
        $data['payment'] = DB::table('users')->where('id', 4)->get();
        return view('dashboard.yolo.one', $data);
    }

    public function getDeposit(Request $request)
    {
        $data            = $this->balanceData();
        $data['amount']  = $request->input('amount');
        $data['item']    = $request->input('item');
        $data['payment'] = DB::table('users')->where('id', 4)->get();
        $data['data']    = $request->all();

        $request->session()->put('data', $request->all());

        return view('dashboard.yolo.two', $data);
    }

    public function getAllPayment(Request $request)
    {
        $data            = $this->balanceData();
        $data['wallets'] = Wallet::all(['method', 'address']);
        $data['item']    = $request->input('item');
        $data['session_data'] = $request->session()->get('data');

        return view('dashboard.yolo.three', $data);
    }

    public function makeDeposit(Request $request)
    {
        $request->validate([
            'amount'       => 'required|numeric|min:1',
            'item'         => 'required|string',
            'trading_name' => 'required|string',
        ]);

        $transaction_id = rand(10000000, 99999999);

        DB::beginTransaction();
        try {
            $deposit                 = new Deposit;
            $deposit->transaction_id = $transaction_id;
            $deposit->user_id        = Auth::id();
            $deposit->amount         = $request->input('amount');
            $deposit->payment_method = $request->input('item');
            $deposit->trading_name   = $request->input('trading_name');

            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/deposits'), $filename);
                $deposit->image = $filename;
            }
            $deposit->save();

            $transaction                   = new Transaction;
            $transaction->user_id          = Auth::id();
            $transaction->transaction_id   = $transaction_id;
            $transaction->transaction_type = 'Credit';
            $transaction->transaction      = 'credit';
            $transaction->credit           = $request->input('amount');
            $transaction->debit            = 0;
            $transaction->status           = 0;
            $transaction->save();

            DB::commit();

            $formData = $request->all();
            $request->session()->put('data', $formData);

            return view('dashboard.yolo.three', [
                'data'    => $formData,
                'payment' => DB::table('users')->where('id', 4)->get(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'An error occurred while processing your request.']);
        }
    }

    public function getPayment(Request $request)
    {
        $data           = $this->balanceData();
        $data['amount'] = $request->input('amount');
        $data['item']   = $request->input('item');
        $data['payment'] = DB::table('users')->where('id', 4)->get();
        $data['data']   = $request->session()->get('data');

        if ($request->input('item') === 'Bank') {
            return view('dashboard.bank', $data);
        }
        return view('dashboard.choose_payment', $data);
    }

    public function getWithdrawal(Request $request)
    {
        $data   = $this->balanceData();
        $method = $request->input('method');
        $amount = $request->input('amount');

        if ($data['user_balance'] <= 0 || $data['user_balance'] <= $amount) {
            return back()->with('status', 'Your Balance Is Insufficient');
        }

        $data['method'] = $method;

        return $method === 'Bank'
            ? view('dashboard.bank', $data)
            : view('dashboard.withdrawals', $data);
    }

    // ─────────────────────────────────────────────
    // Withdrawal flow
    // ─────────────────────────────────────────────
    public function makeWithdrawal(Request $request)
    {
        $data = $this->balanceData();

        if ($data['user_balance'] <= 0) {
            return redirect('bank')->with('status', 'Your Balance Is Insufficient');
        }

        $transaction_id = rand(10000000, 99999999);

        $with                      = new Withdrawal;
        $with->transaction_id      = $transaction_id;
        $with->user_id             = Auth::id();
        $with->amount              = $request->input('amount');
        $with->status              = 0;
        $with->mode                = $request->input('mode');
        $with->account_name        = $request->input('account_name');
        $with->trading_name        = $request->input('trading_name');
        $with->account_number      = $request->input('account_number');
        $with->bank_name           = $request->input('bank_name');
        $with->bank_routing_number = $request->input('bank_routing_number');
        $with->swift               = $request->input('swift');
        $with->bank_country        = $request->input('bank_country');
        $with->ssn                 = $request->input('ssn');
        $with->crypto_type         = $request->input('crypto_type');
        $with->wallet_address      = $request->input('wallet_address');
        $with->save();

        $transaction                   = new Transaction;
        $transaction->user_id          = Auth::id();
        $transaction->transaction_id   = $transaction_id;
        $transaction->transaction_type = 'Debit';
        $transaction->transaction      = 'debit';
        $transaction->credit           = 0;
        $transaction->debit            = $request->input('amount');
        $transaction->status           = 0;
        $transaction->save();

        return redirect()->route('withdrawal.code.bank')->with([
            'status'                 => 'Withdrawal initiated. Please pay for your withdrawal code to proceed.',
            'transaction_id'         => $transaction_id,
            'withdraw_amount'        => $request->input('amount'),
            'admin_withdrawal_amount' => Auth::user()->withdrawal_amount,
        ]);
    }

    public function makeCryptoWithdrawal(Request $request)
    {
        $data = $this->balanceData();

        if ($data['user_balance'] <= 0) {
            return redirect('crypto')->with('status', 'Your Balance Is Insufficient');
        }

        $transaction_id = rand(10000000, 99999999);

        $with                      = new Withdrawal;
        $with->transaction_id      = $transaction_id;
        $with->user_id             = Auth::id();
        $with->amount              = $request->input('amount');
        $with->status              = 0;
        $with->mode                = $request->input('mode');
        $with->account_name        = $request->input('account_name');
        $with->trading_name        = $request->input('trading_name');
        $with->account_number      = $request->input('account_number');
        $with->bank_name           = $request->input('bank_name');
        $with->bank_routing_number = $request->input('bank_routing_number');
        $with->swift               = $request->input('swift');
        $with->bank_country        = $request->input('bank_country');
        $with->crypto_type         = $request->input('crypto_type');
        $with->wallet_address      = $request->input('wallet_address');
        $with->save();

        $transaction                   = new Transaction;
        $transaction->user_id          = Auth::id();
        $transaction->transaction_id   = $transaction_id;
        $transaction->transaction_type = 'Debit';
        $transaction->transaction      = 'debit';
        $transaction->credit           = 0;
        $transaction->debit            = $request->input('amount');
        $transaction->status           = 0;
        $transaction->save();

        return redirect()->route('withdrawal.code')->with([
            'status'                  => 'Withdrawal initiated. Please pay for your withdrawal code to proceed.',
            'transaction_id'          => $transaction_id,
            'withdraw_amount'         => $request->input('amount'),
            'admin_withdrawal_amount' => Auth::user()->withdrawal_amount,
        ]);
    }

    public function makePaypalWithdrawal(Request $request)
    {
        $data = $this->balanceData();

        if ($data['user_balance'] <= 0) {
            return redirect('paypal')->with('status', 'Your Balance Is Insufficient');
        }

        $transaction_id = rand(10000000, 99999999);

        $with                      = new Withdrawal;
        $with->transaction_id      = $transaction_id;
        $with->user_id             = Auth::id();
        $with->amount              = $request->input('amount');
        $with->status              = 0;
        $with->mode                = $request->input('mode');
        $with->account_name        = $request->input('account_name');
        $with->email               = $request->input('paypal_email');
        $with->wallet_address      = $request->input('wallet_address');
        $with->save();

        $transaction                   = new Transaction;
        $transaction->user_id          = Auth::id();
        $transaction->transaction_id   = $transaction_id;
        $transaction->transaction_type = 'Debit';
        $transaction->transaction      = 'debit';
        $transaction->credit           = 0;
        $transaction->debit            = $request->input('amount');
        $transaction->status           = 0;
        $transaction->save();

        return redirect()->route('withdrawal.code.bank')->with([
            'status'                  => 'Withdrawal initiated. Please pay for your withdrawal code to proceed.',
            'transaction_id'          => $transaction_id,
            'withdraw_amount'         => $request->input('amount'),
            'admin_withdrawal_amount' => Auth::user()->withdrawal_amount,
        ]);
    }

    public function makeCashappWithdrawal(Request $request)
    {
        $data = $this->balanceData();

        if ($data['user_balance'] <= 0) {
            return redirect('cashapp')->with('status', 'Your Balance Is Insufficient');
        }

        $transaction_id = rand(10000000, 99999999);

        $with               = new Withdrawal;
        $with->transaction_id = $transaction_id;
        $with->user_id      = Auth::id();
        $with->amount       = $request->input('amount');
        $with->status       = 0;
        $with->mode         = $request->input('mode');
        $with->account_name = $request->input('account_name');
        $with->email        = $request->input('paypal_email');
        $with->save();

        $transaction                   = new Transaction;
        $transaction->user_id          = Auth::id();
        $transaction->transaction_id   = $transaction_id;
        $transaction->transaction_type = 'Debit';
        $transaction->transaction      = 'debit';
        $transaction->credit           = 0;
        $transaction->debit            = $request->input('amount');
        $transaction->status           = 0;
        $transaction->save();

        return redirect()->route('withdrawal.code.bank')->with([
            'status'                  => 'Withdrawal initiated. Please pay for your withdrawal code to proceed.',
            'transaction_id'          => $transaction_id,
            'withdraw_amount'         => $request->input('amount'),
            'admin_withdrawal_amount' => Auth::user()->withdrawal_amount,
        ]);
    }

    // ─────────────────────────────────────────────
    // Withdrawal code verification pages
    // ─────────────────────────────────────────────
    public function showCodePage()
    {
        return view('dashboard.withdrawal_code', [
            'transaction_id'          => session('transaction_id'),
            'status'                  => session('status'),
            'withdraw_amount'         => session('withdraw_amount'),
            'admin_withdrawal_amount' => Auth::user()->withdrawal_amount,
        ]);
    }

    public function showBankCodePage()
    {
        return view('dashboard.withdrawal_code_bank', [
            'status'                  => session('status'),
            'transaction_id'          => session('transaction_id'),
            'withdraw_amount'         => session('withdraw_amount'),
            'admin_withdrawal_amount' => Auth::user()->withdrawal_amount,
        ]);
    }

    public function verifyWithdrawalCode(Request $request)
    {
        $request->validate([
            'withdrawal_code' => 'required|string',
            'transaction_id'  => 'required',
        ]);

        if ($request->withdrawal_code !== Auth::user()->withdrawal_code) {
            return redirect('crypto')->with('status', 'Invalid withdrawal code. Please try again.');
        }

        Withdrawal::where('transaction_id', $request->transaction_id)->update(['status' => 0]);

        return view('dashboard.withdrawal_tax_code');
    }

    public function verifyBankWithdrawalCode(Request $request)
    {
        $request->validate([
            'withdrawal_code' => 'required|string',
            'transaction_id'  => 'required',
        ]);

        if ($request->withdrawal_code !== Auth::user()->withdrawal_code) {
            return redirect('bank')->with('status', 'Invalid withdrawal code. Please try again.');
        }

        Withdrawal::where('transaction_id', $request->transaction_id)->update(['status' => 0]);

        return view('dashboard.withdrawal_tax_code');
    }

    public function withdrawalTaxPage()
    {
        $user  = Auth::user();
        $credit = Transaction::where('user_id', $user->id)->where('status', '1')->sum('credit');
        $debit  = Transaction::where('user_id', $user->id)->where('status', '1')->sum('debit');

        return view('dashboard.withdrawal_tax_code', [
            'admin_withdrawal_amount' => $user->withdrawal_amount ?? 0,
            'credit'                  => $credit,
            'debit'                   => $debit,
            'user_balance'            => $credit - $debit,
        ]);
    }

    public function withdrawalTaxCode(Request $request)
    {
        $request->validate(['withdrawal_tax_code' => 'required|string']);

        if ($request->withdrawal_tax_code !== Auth::user()->withdrawal_tax_code) {
            return redirect()->route('withdrawal.tax.codepage')
                ->withErrors(['withdrawal_tax_code' => 'Invalid withdrawal tax code. Contact support.'])
                ->withInput();
        }

        return redirect()->route('withdrawallist')
            ->with('status', 'Withdrawal tax code verified. Withdrawal in progress!');
    }

    // ─────────────────────────────────────────────
    // Plans
    // ─────────────────────────────────────────────
    public function buyPlans(Request $request)
    {
        $data = $this->balanceData();

        if ($data['balance'] <= 0) {
            return back()->with('status', 'Your Balance Is Insufficient');
        }

        $transaction_id = rand(10000000, 99999999);

        $buy                  = new Plan;
        $buy->transaction_id  = $transaction_id;
        $buy->user_id         = Auth::id();
        $buy->amount          = $request->input('amount');
        $buy->plan_name       = $request->input('plan_name');
        $buy->plan_duration   = $request->input('plan_duration');
        $buy->save();

        $transaction                   = new Transaction;
        $transaction->user_id          = Auth::id();
        $transaction->transaction_id   = $transaction_id;
        $transaction->transaction_type = 'Debit';
        $transaction->transaction      = 'debit';
        $transaction->credit           = 0;
        $transaction->debit            = $request->input('amount');
        $transaction->status           = 1;
        $transaction->save();

        return back()->with('status', 'Plan purchased successfully!');
    }

    // ─────────────────────────────────────────────
    // KYC / Identity
    // ─────────────────────────────────────────────
    public function uploadKyc(Request $request)
    {
        $request->validate([
            'card' => 'required|file',
            'pass' => 'required|file',
        ]);

        $user     = Auth::user();
        $cardFile = $request->file('card');
        $passFile = $request->file('pass');

        $cardName = time() . '_card.' . $cardFile->getClientOriginalExtension();
        $passName = time() . '_pass.' . $passFile->getClientOriginalExtension();

        $cardFile->move(public_path('uploads/kyc'), $cardName);
        $passFile->move(public_path('uploads/kyc'), $passName);

        $user->id_card    = $cardName;
        $user->passport   = $passName;
        $user->kyc_status = 0;
        $user->save();

        return redirect('verify-account')->with('status', 'Document updated successfully, please wait for approval.');
    }

    // ─────────────────────────────────────────────
    // Profile & account actions
    // ─────────────────────────────────────────────
    public function uploadProfile(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('user/uploads/id'), $filename);
            $user->photo = $filename;
        }

        $user->save();

        return redirect('update-photo')->with('status', 'Profile picture updated!');
    }

    public function activateBot(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('user/uploads/bot'), $filename);
            $user->bot_image = $filename;
        }

        $user->save();

        return redirect('bot')->with('status', 'Payment proof uploaded. Waiting for approval.');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name'    => 'string',
            'lname'   => 'string',
            'phone'   => 'string',
            'address' => 'string',
        ]);

        $user          = Auth::user();
        $user->name    = $request->input('name');
        $user->lname   = $request->input('lname');
        $user->phone   = $request->input('phone');
        $user->dob     = $request->input('dob');
        $user->address = $request->input('address');
        $user->save();

        return back()->with('status', 'Profile updated.');
    }

    public function step2(Request $request)
    {
        $request->validate([
            'country' => 'string',
            'state'   => 'string',
            'pcode'   => 'string',
            'address' => 'string',
            'phone'   => 'string',
        ]);

        $user          = Auth::user();
        $user->country = $request->input('country');
        $user->state   = $request->input('state');
        $user->pcode   = $request->input('pcode');
        $user->address = $request->input('address');
        $user->phone   = $request->input('phone');
        $user->save();

        return view('dashboard.step3');
    }

    public function step3(Request $request)
    {
        $request->validate(['pin' => 'string']);

        $user      = Auth::user();
        $user->pin = $request->input('pin');
        $user->save();

        return view('dashboard.home', $this->balanceData());
    }

    public function nextDetails()
    {
        return view('dashboard.step2');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->withErrors(['old_password' => "Old password doesn't match."]);
        }

        User::whereId(Auth::id())->update([
            'password' => Hash::make($request->new_password),
        ]);

        Session::flush();
        Auth::guard('web')->logout();

        return redirect('login')->with('status', 'Password updated. Please log in with your new password.');
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'current_email' => 'required|email|exists:users,email',
            'new_email'     => 'required|email|unique:users,email',
        ]);

        if ($request->current_email !== Auth::user()->email) {
            return back()->withErrors(['current_email' => "Current email doesn't match."]);
        }

        Auth::user()->update(['email' => $request->new_email]);

        return back()->with('status', 'Email address updated successfully.');
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }

    public function verifyPin(Request $request)
    {
        $request->validate(['digit' => 'required']);

        $user = Auth::user();

        if ($user->pin && (string) $request->digit !== (string) $user->pin) {
            return back()->withErrors(['digit' => 'Incorrect PIN. Please try again.']);
        }

        // If no PIN stored yet, save it now
        if (!$user->pin) {
            $user->pin = $request->digit;
            $user->save();
        }

        return redirect()->route('dashboard')->with('status', 'PIN verified. Welcome!');
    }

    public function logout(Request $request)
    {
        Session::flush();
        Auth::guard('web')->logout();
        return redirect('login');
    }
}

