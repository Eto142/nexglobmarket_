<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Kyc;
use App\Models\Plan;
use App\Models\User;
use App\Models\Profit;
use App\Models\Deposit;
use App\Models\Earning;
use App\Models\Traders;
use App\Models\Refferal;
use App\Models\Withdrawal;
use App\Mail\sendUserEmail;
use App\Mail\DepositApproveEmail;
use App\Mail\WithdrawalApproveEmail;
use App\Mail\UpdateNotificationMail;
use App\Models\Debitprofit;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Mail\ProfitLimitMail;
use App\Mail\UserNotificationMail;
use App\Mail\WithdrawalAmountUpdatedMail;
use App\Mail\WithdrawalTaxAmountUpdatedMail;
use App\Mail\WithdrawalTaxCodeUpdated;
use App\Models\Wallet;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserManagementController extends Controller
{
    public function viewUser(Request $request)
    {
        $query = DB::table('users')->where('usertype', '0');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $user = $query->paginate(15);
        return view('admin.manage_users', compact('user'));
    }

    public function usersDeposit()
    {
        $user         = DB::table('users')->get();
        $deposit      = DB::table('deposits')->get();
        $totalDeposit = DB::table('deposits')->count();
        $activeDeposit   = DB::table('deposits')->where('status', '1')->sum('amount');
        $inactiveDeposit = DB::table('deposits')->where('status', '0')->sum('amount');
        return view('admin.users_deposits', compact('deposit', 'user', 'totalDeposit', 'activeDeposit', 'inactiveDeposit'));
    }

    public function usersWithdrawals()
    {
        $user             = DB::table('users')->get();
        $withdrawal       = DB::table('withdrawals')->get();
        $totalWithdrawal  = DB::table('withdrawals')->count();
        $activeWithdrawal   = DB::table('withdrawals')->where('status', '1')->sum('amount');
        $inactiveWithdrawal = DB::table('withdrawals')->where('status', '0')->sum('amount');
        return view('admin.users_withdrawals', compact('withdrawal', 'user', 'totalWithdrawal', 'activeWithdrawal', 'inactiveWithdrawal'));
    }

    public function usersProfit()
    {
        $user   = DB::table('users')->get();
        $profit = DB::table('profits')->get();
        return view('admin.users_profits', compact('profit', 'user'));
    }

    // Copy Trader
    public function addTrader()
    {
        $data['traders'] = DB::table('traders')->get();
        return view('admin.copytrader', $data);
    }

    public function saveTrader(Request $request)
    {
        $validatedData = $request->validate([
            'name'         => 'required',
            'win_rate'     => 'required',
            'profit_share' => 'required',
        ]);

        $traderData = [
            'name'         => $validatedData['name'],
            'win_rate'     => $validatedData['win_rate'],
            'profit_share' => $validatedData['profit_share'],
        ];

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $ext      = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/trader', $filename);
            $traderData['image'] = $filename;
        }

        Traders::create($traderData);

        return back()->with('message', 'Trader Created Successfully');
    }

    public function deleteTrader($id)
    {
        $trader = Traders::findOrFail($id);
        $trader->delete();
        return back()->with('message', 'Trader deleted Successfully!');
    }

    public function editTrader($id)
    {
        $editTrader = DB::table('traders')->where('id', $id)->first();
        return view('admin.edit-trader', compact('editTrader'));
    }

    public function updateTrader(Request $request, int $trader_id)
    {
        $trader = Traders::findOrFail($trader_id);
        $trader->name         = $request['name'];
        $trader->win_rate     = $request['win_rate'];
        $trader->profit_share = $request['profit_share'];

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $ext      = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/trader', $filename);
            $trader->image = $filename;
        }

        $trader->update($request->all());
        return back()->with('message', 'Expert Trader Updated Successfully');
    }

    public function userProfile($id)
    {
        $userProfile = DB::table('users')->where('id', $id)->first();
        $userProfit  = DB::table('profits')->where('user_id', $id)->orderBy('id', 'desc')->get();
        $kyc         = DB::table('kycs')->where('user_id', $id)->orderBy('id', 'desc')->get();

        $data['deposit']    = Deposit::where('user_id', $id)->orderBy('id', 'desc')->get();
        $data['withdrawal'] = Withdrawal::where('user_id', $id)->orderBy('id', 'desc')->get();
        $data['earning']    = Earning::where('user_id', $id)->orderBy('id', 'desc')->get();

        $totalDeposit    = DB::table('deposits')->where('user_id', $id)->where('status', '1')->sum('amount');
        $totalEarning    = DB::table('earnings')->where('user_id', $id)->sum('amount');
        $addProfit       = DB::table('profits')->where('user_id', $id)->sum('amount');
        $debitProfit     = DB::table('debitprofits')->where('user_id', $id)->sum('amount');
        $totalProfit     = $addProfit - $debitProfit;
        $totalBonus      = DB::table('refferals')->where('user_id', $id)->sum('amount');
        $totalWithdrawal = DB::table('withdrawals')->where('user_id', $id)->sum('amount');
        $totalBalance    = $totalDeposit + $totalEarning + $totalProfit + $totalBonus - $totalWithdrawal;

        $data['credit']       = Transaction::where('user_id', $id)->where('status', '1')->sum('credit');
        $data['debit']        = Transaction::where('user_id', $id)->where('status', '1')->sum('debit');
        $data['user_balance'] = $data['credit'] - $data['debit'];

        $notifications = Notification::where('user_id', $id)->orderBy('id', 'desc')->get();

        return view('admin.user', $data, compact('userProfile', 'userProfit', 'totalBalance', 'totalProfit', 'totalDeposit', 'totalBonus', 'totalWithdrawal', 'kyc', 'notifications'));
    }

    public function sendUserMail($id)
    {
        $data['user'] = DB::table('users')->where('id', $id)->first();
        return view('admin.send_user_mail', $data);
    }

    public function sendMail(Request $request)
    {
        $email = $request->input('email');
        $data  = [
            'message' => $request->message,
            'subject' => $request->subject,
        ];

        Mail::to($email)->send(new sendUserEmail($data));
        return back()->with('status', 'Email Successfully sent');
    }

    public function ApproveDeposit(Request $request, $id)
    {
        $user_id       = $request->user_id;
        $transaction   = Deposit::where('user_id', $user_id)->first();
        $transaction_id = $transaction->transaction_id;

        DB::table('deposits')->where('id', $id)->update(['status' => 1]);
        DB::table('transactions')->where('transaction_id', $transaction_id)->update(['status' => 1]);

        $user = User::findOrFail($user_id);
        Mail::to($user->email)->send(new DepositApproveEmail($user));

        return redirect()->back()->with('message', 'Deposit Has Been Approved Successfully');
    }

    public function DeclineDeposit(Request $request, $id)
    {
        $user_id       = $request->user_id;
        $transaction   = Deposit::where('user_id', $user_id)->first();
        $transaction_id = $transaction->transaction_id;

        DB::table('deposits')->where('id', $id)->update(['status' => 2]);
        DB::table('transactions')->where('transaction_id', $transaction_id)->update(['status' => 2]);

        return redirect()->back()->with('message', 'Deposit Declined');
    }

    public function ApproveWithdrawal(Request $request, $id)
    {
        $user_id       = $request->user_id;
        $transaction   = Withdrawal::where('user_id', $user_id)->first();
        $transaction_id = $transaction->transaction_id;

        DB::table('withdrawals')->where('id', $id)->update(['status' => $request->status]);
        DB::table('transactions')->where('transaction_id', $transaction_id)->update(['status' => $request->status]);

        if ($request->status == 1) {
            $user = User::findOrFail($user_id);
            Mail::to($user->email)->send(new WithdrawalApproveEmail($user));
        }

        return redirect()->back()->with('message', 'Withdrawal Has Been Approved Successfully');
    }

    public function DeclineWithdrawal(Request $request, $id)
    {
        $user_id       = $request->user_id;
        $transaction   = Withdrawal::where('user_id', $user_id)->first();
        $transaction_id = $transaction->transaction_id;

        DB::table('withdrawals')->where('id', $id)->update(['status' => $request->status]);
        DB::table('transactions')->where('transaction_id', $transaction_id)->update(['status' => $request->status]);

        return redirect()->back()->with('message', 'Withdrawal Declined');
    }

    public function getUserProfit($id)
    {
        $userProfile = DB::table('users')->where('id', $id)->first();
        return view('admin.add_profit', compact('userProfile'));
    }

    public function addUserProfit(Request $request)
    {
        $transaction_id = rand(76503737, 12344994);

        $topUp = new Profit;
        $topUp->transaction_id = $transaction_id;
        $topUp->user_id        = $request['user_id'];
        $topUp->amount         = $request['amount'];
        $topUp->save();

        $transaction = new Transaction;
        $transaction->user_id          = $request['user_id'];
        $transaction->transaction_id   = $transaction_id;
        $transaction->transaction_type = "Profit";
        $transaction->transaction      = "credit";
        $transaction->credit           = $request['amount'];
        $transaction->debit            = "0";
        $transaction->status           = 1;
        $transaction->save();

        return redirect()->back()->with('message', 'User Profit Topped Up Successfully');
    }

    public function getDebitProfit($id)
    {
        $userProfile = DB::table('users')->where('id', $id)->first();
        return view('admin.debit_profit', compact('userProfile'));
    }

    public function debitUserProfit(Request $request)
    {
        $transaction_id = rand(76503737, 12344994);

        $topUp = new Debitprofit;
        $topUp->transaction_id = $transaction_id;
        $topUp->user_id        = $request['user_id'];
        $topUp->amount         = $request['amount'];
        $topUp->save();

        $transaction = new Transaction;
        $transaction->user_id          = $request['user_id'];
        $transaction->transaction_id   = $transaction_id;
        $transaction->transaction_type = "Debit";
        $transaction->transaction      = "debit";
        $transaction->credit           = "0";
        $transaction->debit            = $request['amount'];
        $transaction->status           = 1;
        $transaction->save();

        return redirect()->back()->with('message', 'User Total Profit Debited Successfully');
    }

    public function getUserDeposit($id)
    {
        $userProfile = DB::table('users')->where('id', $id)->first();
        return view('admin.add_deposit', compact('userProfile'));
    }

    public function addUserDeposit(Request $request)
    {
        $transaction_id = rand(76503737, 12344994);

        $topUp = new Deposit;
        $topUp->transaction_id  = $transaction_id;
        $topUp->user_id         = $request['user_id'];
        $topUp->payment_method  = $request['payment_method'];
        $topUp->amount          = $request['amount'];
        $topUp->status          = 1;
        $topUp->created_at      = $request['deposit_date'];
        $topUp->save();

        $transaction = new Transaction;
        $transaction->user_id          = $request['user_id'];
        $transaction->transaction_id   = $transaction_id;
        $transaction->transaction_type = "Credit";
        $transaction->transaction      = "credit";
        $transaction->credit           = $request['amount'];
        $transaction->debit            = "0";
        $transaction->status           = 1;
        $transaction->save();

        return redirect()->back()->with('message', 'User Deposit Added Successfully');
    }

    public function getUserReferral($id)
    {
        $userProfile = DB::table('users')->where('id', $id)->first();
        return view('admin.add_referral', compact('userProfile'));
    }

    public function addUserReferral(Request $request)
    {
        $transaction_id = rand(76503737, 12344994);

        $topUp = new Refferal;
        $topUp->transaction_id = $transaction_id;
        $topUp->user_id        = $request['user_id'];
        $topUp->amount         = $request['amount'];
        $topUp->save();

        $transaction = new Transaction;
        $transaction->user_id          = $request['user_id'];
        $transaction->transaction_id   = $transaction_id;
        $transaction->transaction_type = "Credit";
        $transaction->transaction      = "credit";
        $transaction->credit           = $request['amount'];
        $transaction->debit            = "0";
        $transaction->status           = 1;
        $transaction->save();

        return redirect()->back()->with('message', 'User Bonus Added Successfully');
    }

    public function updateWallet()
    {
        $wallets = Wallet::all();
        return view('admin.update_wallet', compact('wallets'));
    }

    public function saveWallet(Request $request)
    {
        $update               = Auth::user();
        $update->eth_address  = $request['eth_address'];
        $update->btc_address  = $request['btc_address'];
        $update->usdt_address = $request['usdt_address'];
        $update->save();
        return back()->with('status', 'Wallet Details Updated Successfully');
    }

    public function chooseWallet(Request $request)
    {
        $method = $request->input('method');

        if ($method == 'btc') {
            return view('admin.btc');
        } elseif ($method == 'eth') {
            return view('admin.eth');
        } elseif ($method == 'usdt') {
            return view('admin.usdt');
        } else {
            return back()->with('status', 'You have not chosen a wallet');
        }
    }

    public function updateTrc(Request $request)
    {
        $update               = Auth::user();
        $update->usdt_address = $request['usdt_address'];
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $ext      = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('manager/uploads/manager', $filename);
            $update->usdtImage = $filename;
        }
        $update->save();
        return redirect('admin/update-wallet')->with('status', 'Trc Details Updated Successfully');
    }

    public function updateBtc(Request $request)
    {
        $update              = Auth::user();
        $update->btc_address = $request['btc_address'];
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $ext      = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('manager/uploads/manager', $filename);
            $update->btcImage = $filename;
        }
        $update->save();
        return redirect('admin/update-wallet')->with('status', 'Btc Details Updated Successfully');
    }

    public function updateEth(Request $request)
    {
        $update              = Auth::user();
        $update->eth_address = $request['eth_address'];
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $ext      = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('manager/uploads/manager', $filename);
            $update->ethImage = $filename;
        }
        $update->save();
        return redirect('admin/update-wallet')->with('status', 'Eth Details Updated Successfully');
    }

    public function updateBank(Request $request)
    {
        $update                = Auth::user();
        $update->bankName      = $request->bank_name;
        $update->accountName   = $request->account_name;
        $update->accountNumber = $request->account_number;
        $update->save();
        return redirect('admin/update-wallet')->with('status', 'Bank Details Updated Successfully');
    }

    public function sendTestMail()
    {
        return view('admin.send_test_mail');
    }

    public function allTransactions()
    {
        $data['user_transactions'] = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
            ->select('transactions.*', 'users.name as user_name')
            ->orderBy('transactions.id', 'desc')
            ->get();

        return view('admin.transactions', $data);
    }

    public function sendUserEmail(Request $request)
    {
        $email = $request->input('email');
        $data  = [
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        Mail::to($email)->send(new sendUserEmail($data));
        return back()->with('status', 'Email Successfully sent');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('message', 'User deleted Successfully');
    }

    public function acceptKyc($id)
    {
        $user             = User::findOrFail($id);
        $user->kyc_status = '1';
        $user->save();
        return back()->with('message', 'Kyc Approved Successfully');
    }

    public function rejectKyc($id)
    {
        $user             = User::findOrFail($id);
        $user->kyc_status = '2';
        $user->save();
        return back()->with('message', 'Kyc Rejected Successfully');
    }

    public function acceptBot($id)
    {
        $user             = User::findOrFail($id);
        $user->bot_status = '1';
        $user->save();
        return back()->with('message', 'Bot Approved Successfully');
    }

    public function rejectBot($id)
    {
        $user             = User::findOrFail($id);
        $user->bot_status = '2';
        $user->save();
        return back()->with('message', 'Bot Rejected Successfully');
    }

    public function updateSignalStrength(Request $request, $id)
    {
        $user     = User::findOrFail($id);
        $strength = $request->signal_strength;

        $user->signal_strength = $strength;
        $user->save();

        $name    = $user->name ?? 'Trader';
        $subject = '';
        $body    = '';

        if ($strength < 40) {
            $subject = 'Weak Market Signal Detected – Unlock Your Trading Potential';
            $body    = "Hello {$name},<br><br>Your current trading signal is <b>Weak (0–39%)</b>. Market conditions are uncertain, and profits may be limited at this stage.<br><br>By completing a signal payment, you can unlock enhanced insights and actionable trading guidance.<br><br><a href='#' style='background:#007bff;color:#fff;padding:10px 15px;border-radius:6px;text-decoration:none;'>🔓 Unlock Enhanced Signals</a>";
        } elseif ($strength < 70) {
            $subject = 'Moderate Signal – Increase Your Trading Edge';
            $body    = "Hello {$name},<br><br>Your trading signal is currently <b>Moderate (40–69%)</b>. A signal payment grants you access to refined strategies and expert insights.<br><br><a href='#' style='background:#28a745;color:#fff;padding:10px 15px;border-radius:6px;text-decoration:none;'>🚀 Upgrade Your Signal</a>";
        } elseif ($strength < 85) {
            $subject = 'Strong Signal – High-Probability Trades Available';
            $body    = "Hello {$name},<br><br>Your signal is <b>Strong (70–84%)</b>. Completing your signal payment unlocks full access to advanced trading strategies.<br><br><a href='#' style='background:#17a2b8;color:#fff;padding:10px 15px;border-radius:6px;text-decoration:none;'>💹 Access Full Signal Insights</a>";
        } elseif ($strength < 95) {
            $subject = 'Very Strong Signal – Trade with Confidence';
            $body    = "Hello {$name},<br><br>Your signal strength is <b>Very Strong (85–94%)</b>. Paying for your signal provides complete access to top-tier trading insights.<br><br><a href='#' style='background:#6f42c1;color:#fff;padding:10px 15px;border-radius:6px;text-decoration:none;'>🔑 Unlock Full Trading Insights</a>";
        } else {
            $subject = '🚀 Extreme Signal Alert – Unlock Maximum Profit Now!';
            $body    = "Hello {$name},<br><br>The market is showing an <b>Extreme Signal (95–100%)</b>. Complete your signal payment to unlock premium insights.<br><br><a href='#' style='background:#dc3545;color:#fff;padding:10px 15px;border-radius:6px;text-decoration:none;'>🔥 Unlock Maximum Profit</a>";
        }

        Mail::send([], [], function ($message) use ($user, $subject, $body) {
            $message->to($user->email)
                    ->subject($subject)
                    ->html($body);
        });

        return back()->with('message', 'Signal Strength updated and email sent successfully!');
    }

    public function updateNotification(Request $request, $id)
    {
        $user                    = User::where('id', $id)->first();
        $user->update_notification = $request->update_notification;
        $user->save();

        Mail::to($user->email)->send(new UpdateNotificationMail($request->update_notification));

        return back()->with('message', 'Notification update successful');
    }

    public function updateEscrow(Request $request, $id)
    {
        $user               = User::where('id', $id)->first();
        $user->update_escrow = $request->update_escrow;
        $user->save();
        return back()->with('message', 'Escrow Amount updated successfully');
    }

    public function updatewithdrawalcode(Request $request, $id)
    {
        $user                  = User::where('id', $id)->first();
        $user->withdrawal_code = $request->withdrawal_code;
        $user->save();
        return back()->with('message', 'Withdrawal Code updated successfully');
    }

    public function clearAccount($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->debitprofit()->delete();
            $user->referral()->delete();
            $user->profit()->delete();
            $user->withdrawal()->delete();
            $user->deposit()->delete();
            $user->transaction()->delete();
            return back()->with('message', 'Records deleted successfully');
        }
        return back()->with('message', 'User Not Found');
    }

    public function manageDeposit()
    {
        $data['deposits'] = User::join('deposits', 'users.id', '=', 'deposits.user_id')
                                ->get(['users.email', 'users.name', 'deposits.*']);
        return view('admin.manage_deposit', $data);
    }

    public function manageWithdrawal()
    {
        $data['withdrawals'] = User::join('withdrawals', 'users.id', '=', 'withdrawals.user_id')
                                   ->get(['users.email', 'users.name', 'withdrawals.*']);
        return view('admin.manage_withdrawal', $data);
    }

    public function userSuspension($id)
    {
        DB::table('users')->where('id', $id)->update(['user_status' => '2']);
        return redirect()->back()->with('message', 'User Has Been Suspended Successfully');
    }

    public function updateProfitLimitStatus(Request $request, $id)
    {
        $request->validate([
            'profit_limit_status' => 'required|in:0,1',
        ]);

        $user           = User::findOrFail($id);
        $previousStatus = $user->profit_limit_status;
        $user->profit_limit_status = $request->profit_limit_status;
        $user->save();

        if ($previousStatus == 0 && $user->profit_limit_status == 1) {
            Mail::to($user->email)->send(new ProfitLimitMail($user));
        }

        return back()->with('message', 'Profit limit status updated successfully');
    }

    public function addNotification(Request $request, $id)
    {
        $request->validate([
            'update_notification' => 'required|string',
        ]);

        $user = User::findOrFail($id);

        Notification::create([
            'user_id' => $user->id,
            'message' => $request->update_notification,
        ]);

        Mail::to($user->email)->send(new UserNotificationMail($user, $request->update_notification));

        return back()->with('message', 'Push Notification added and email sent successfully!');
    }

    public function deleteNotification($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        return back()->with('message', 'Push Notification deleted successfully!');
    }

    public function updatewithdrawalTaxcode(Request $request, $id)
    {
        $request->validate([
            'withdrawal_tax_code' => 'required|string',
        ]);

        $user                     = User::findOrFail($id);
        $user->withdrawal_tax_code = $request->withdrawal_tax_code;
        $user->save();

        Mail::to($user->email)->send(new WithdrawalTaxCodeUpdated($user));

        return back()->with('message', 'Withdrawal Tax Code updated successfully and email sent.');
    }

    public function updatewithdrawalpercentage(Request $request, $id)
    {
        $user                       = User::where('id', $id)->first();
        $user->withdrawal_percentage = $request->withdrawal_percentage;
        $user->save();
        return back()->with('message', 'Withdrawal Percentage updated successfully');
    }

    public function updatewithdrawalamount(Request $request, $id)
    {
        $request->validate([
            'withdrawal_amount' => 'required|numeric|min:0',
        ]);

        $user                    = User::findOrFail($id);
        $user->withdrawal_amount = $request->withdrawal_amount;
        $user->save();

        Mail::to($user->email)->send(new WithdrawalAmountUpdatedMail($user));

        return back()->with('message', 'Withdrawal amount updated successfully');
    }

    public function updatewithdrawalTaxamount(Request $request, $id)
    {
        $request->validate([
            'withdrawal_tax_amount' => 'required|numeric|min:0',
        ]);

        $user                        = User::findOrFail($id);
        $user->withdrawal_tax_amount = $request->withdrawal_tax_amount;
        $user->save();

        Mail::to($user->email)->send(new WithdrawalTaxAmountUpdatedMail($user));

        return back()->with('message', 'Withdrawal Tax amount updated successfully');
    }

    public function updateSignal(Request $request)
    {
        $update                  = Auth::user();
        $update->signal_strength = $request['signal_strength'];
        $update->save();
        return back()->with('status', 'Signal Strength Updated Successfully');
    }

    public function toggleKycNotice(Request $request, $id)
    {
        $request->validate([
            'show_kyc_notice' => 'required|in:0,1',
        ]);

        $user                  = User::findOrFail($id);
        $user->show_kyc_notice = $request->show_kyc_notice;
        $user->save();

        return back()->with('message', 'KYC notice display updated successfully');
    }

    public function toggleSignalDisplay(Request $request, $id)
    {
        $request->validate([
            'show_signal_strength' => 'required|in:0,1',
        ]);

        $user                       = User::findOrFail($id);
        $user->show_signal_strength = $request->show_signal_strength;
        $user->save();

        return back()->with('message', 'Signal strength display updated successfully');
    }
}
