<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Ptc;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ManagePtcController extends Controller
{
    public function index()
    {
        $pageTitle = 'PTC Advertisements';
        $ads = $this->ptcData();
        return view('admin.ptc.index',compact('pageTitle','ads'));
    }

    public function pending()
    {
        $pageTitle = 'Pending PTC Advertisements';
        $ads = $this->ptcData('pending');
        return view('admin.ptc.index',compact('pageTitle','ads'));
    }

    public function active()
    {
        $pageTitle = 'Active PTC Advertisements';
        $ads = $this->ptcData('active');
        return view('admin.ptc.index',compact('pageTitle','ads'));
    }

    public function inactive()
    {
        $pageTitle = 'Inactive PTC Advertisements';
        $ads = $this->ptcData('inactive');
        return view('admin.ptc.index',compact('pageTitle','ads'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected PTC Advertisements';
        $ads = $this->ptcData('rejected');
        return view('admin.ptc.index',compact('pageTitle','ads'));
    }

    private function ptcData($scope = null){
        if ($scope) {
            $ads = Ptc::$scope()->with('user')->orderBy('id','desc');
        }else{
            $ads = Ptc::with('user')->orderBy('id','desc');
        }

        return $ads->paginate(getPaginate());
    }

    public function create(Request $request)
    {
        $pageTitle = 'Add Advertisement';
        return view('admin.ptc.create',compact('pageTitle'));
    }

    public function edit(Request $request,$id)
    {
        $pageTitle = 'Edit Advertisement';
        $ptc = Ptc::findOrFail($id);
        return view('admin.ptc.edit',compact('pageTitle','ptc'));
    }

    public function store(Request $request)
    {
        $this->validation($request,[
            'website_link' => 'nullable|url|required_without_all:banner_image,script,youtube',
            'banner_image' => 'nullable|mimes:jpeg,jpg,png,gif|required_without_all:website_link,script,youtube',
            'script' => 'nullable|required_without_all:website_link,banner_image,youtube',
            'youtube' => 'nullable|url|required_without_all:website_link,banner_image,script',
        ]);

        $ptc = new Ptc();
        $this->submit($request,$ptc);
        $notify[] = ['success', 'Advertisement added successfully.'];
        return back()->withNotify($notify);
    }

    public function update(Request $request,$id)
    {
        $this->validation($request);
        $ptc = Ptc::findOrFail($id);
        $this->submit($request,$ptc,1);
        $notify[] = ['success', 'Advertisement updated successfully.'];
        return back()->withNotify($notify);
    }


    public function submit($request,$ptc,$isUpdate = 0)
    {
        $ptc->title = $request->title;
        $ptc->amount = $request->amount;
        $ptc->duration = $request->duration;
        $ptc->max_show = $request->max_show;
        if (!$isUpdate) {
            $ptc->remain = $request->max_show;
        }
        $ptc->ads_type = $request->ads_type;
        $user = $ptc->user;
        if ($isUpdate && $request->status == 3 && $ptc->user_id != 0 && $ptc->status != 3) {
            $general = GeneralSetting::first();
            if ($ptc->ads_type == 1) {
                $price = @$general->ads_setting->ad_price->url ?? 0;
            } elseif ($ptc->ads_type == 2) {
                $price = @$general->ads_setting->ad_price->image ?? 0;
            } elseif($ptc->ads_type == 3) {
                $price = @$general->ads_setting->ad_price->script ?? 0;
            } else {
                $price = @$general->ads_setting->ad_price->youtube ?? 0;
            }
            $amount = $ptc->remain * $price;
            $user->balance += $amount;
            $user->save();

            $trx = getTrx();
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'PTC advertisement rejected';
            $transaction->remark = 'ad_reject';
            $transaction->trx = $trx;
            $transaction->save();

            notify($user,'PTC_REJECT',[
                'title'=>$ptc->title,
                'quantity'=>$ptc->max_show,
                'duration'=>$ptc->duration,
                'back_amount'=>$amount,
                'post_balance'=>$user->balance,
                'trx'=>$trx,
            ]);

        }

        if ($ptc->status == 2 && $request->status == 1 && $user) {
            notify($user,'PTC_APPROVE',[
                'title'=>$ptc->title,
                'quantity'=>$ptc->max_show,
                'duration'=>$ptc->duration,
            ]);
        }

        $ptc->status = $request->status ?? 1;

        if($request->ads_type == 1){
            $ptc->ads_body = $request->website_link;
        }elseif($request->ads_type == 2){

            if ($request->hasFile('banner_image')) {
                if ($isUpdate == 1) {
                    $old = $ptc->ads_body;
                    fileManager()->removeFile(getFilePath('ptc').'/'.$old);
                }
                $directory = date("Y")."/".date("m")."/".date("d");
                $path = getFilePath('ptc').'/'.$directory;
                $filename = $directory.'/'.fileUploader($request->banner_image, $path);
                $ptc->ads_body = $filename;
            }
        }elseif($request->ads_type == 3){
            $ptc->ads_body = $request->script;
        }else{
            $ptc->ads_body = $request->youtube;
        }

        $ptc->save();
    }


    public function validation($request,$rules = [])
    {
        $globalRules = [
            'title' => 'required',
            'amount' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:1',
            'max_show' => 'required|numeric|min:1',
            'ads_type' => 'required|integer',
        ];
        $rules = array_merge($globalRules,$rules);
        $request->validate($rules);
    }
}
