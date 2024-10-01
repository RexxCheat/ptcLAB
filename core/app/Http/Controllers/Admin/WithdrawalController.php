<?php

namespace App\Http\Controllers\Admin;

use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function pending()
    {
        $pageTitle = 'Pending Withdrawals';
        $withdrawals = $this->withdrawalData('pending');
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals'));
    }

    public function approved()
    {
        $pageTitle = 'Approved Withdrawals';
        $withdrawals = $this->withdrawalData('approved');
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Withdrawals';
        $withdrawals = $this->withdrawalData('rejected');
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals'));
    }

    public function log()
    {
        $pageTitle = 'Withdrawals Log';
        $withdrawalData = $this->withdrawalData($scope = null, $summery = true);
        $withdrawals = $withdrawalData['data'];
        $summery = $withdrawalData['summery'];
        $successful = $summery['successful'];
        $pending = $summery['pending'];
        $rejected = $summery['rejected'];


        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals','successful','pending','rejected'));
    }

    protected function withdrawalData($scope = null, $summery = false){
        if ($scope) {
            $withdrawals = Withdrawal::$scope();
        }else{
            $withdrawals = Withdrawal::where('status','!=',0);
        }

        $request = request();
        //search
        $search = $request->search;
        $withdrawals = $withdrawals->where('status','!=',0)->where(function ($q) use ($search) {
            $q->where('trx', 'like',"%$search%")
                ->orWhereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like',"%$search%");
            });
        });


        //date search
        if($request->date) {
            $date = explode('-',$request->date);
            $request->merge([
                'start_date'=> trim(@$date[0]),
                'end_date'  => trim(@$date[1])
            ]);
            $request->validate([
                'start_date'    => 'required|date_format:m/d/Y',
                'end_date'      => 'nullable|date_format:m/d/Y'
            ]);
            if($request->end_date) {
                $endDate = Carbon::parse($request->end_date)->addHours(23)->addMinutes(59)->addSecond(59);
                $withdrawals   = $withdrawals->whereBetween('created_at', [Carbon::parse($request->start_date), $endDate]);
            }else{
                $withdrawals   = $withdrawals->whereDate('created_at', Carbon::parse($request->start_date));
            }
        }

        //via method
        if ($request->method) {
            $withdrawals = $withdrawals->where('method_id',$request->method);
        }
        if (!$summery) {
            return $withdrawals->with(['user','method'])->orderBy('id','desc')->paginate(getPaginate());
        }else{

            $successful = clone $withdrawals;
            $pending = clone $withdrawals;
            $rejected = clone $withdrawals;

            $successfulSummery = $successful->where('status',1)->sum('amount');
            $pendingSummery = $pending->where('status',2)->sum('amount');
            $rejectedSummery = $rejected->where('status',3)->sum('amount');


            return [
                'data'=> $withdrawals->with(['user','method'])->orderBy('id','desc')->paginate(getPaginate()),
                'summery'=>[
                    'successful'=>$successfulSummery,
                    'pending'=>$pendingSummery,
                    'rejected'=>$rejectedSummery,
                ]
            ];
        }
    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $withdrawal = Withdrawal::where('id',$id)->where('status', '!=', 0)->with(['user','method'])->firstOrFail();
        $pageTitle = $withdrawal->user->username.' Withdraw Requested ' . showAmount($withdrawal->amount) . ' '.$general->cur_text;
        $details = $withdrawal->withdraw_information ? json_encode($withdrawal->withdraw_information) : null;

        return view('admin.withdraw.detail', compact('pageTitle', 'withdrawal','details'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id',$request->id)->where('status',2)->with('user')->firstOrFail();
        $withdraw->status = 1;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        notify($withdraw->user, 'WITHDRAW_APPROVE', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdrawal approved successfully'];
        return to_route('admin.withdraw.pending')->withNotify($notify);
    }


    public function reject(Request $request)
    {
        $general = GeneralSetting::first();
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id',$request->id)->where('status',2)->with('user')->firstOrFail();

        $withdraw->status = 3;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $user = $withdraw->user;
        $user->balance += $withdraw->amount;
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->remark = 'withdraw_reject';
        $transaction->details = showAmount($withdraw->amount) . ' ' . $general->cur_text . ' Refunded from withdrawal rejection';
        $transaction->trx = $withdraw->trx;
        $transaction->save();




        notify($user, 'WITHDRAW_REJECT', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($user->balance),
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdrawal rejected successfully'];
        return to_route('admin.withdraw.pending')->withNotify($notify);
    }

}
