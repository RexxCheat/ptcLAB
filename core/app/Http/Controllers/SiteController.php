<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Page;
use App\Models\Plan;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SiteController extends Controller
{
    public function index(){
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        $pageTitle = 'Home';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','/')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle','sections'));
    }

    public function blog()
    {
        $pageTitle = 'Blog';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','blog')->firstOrFail();
        $blogs = Frontend::where('data_keys','blog.element')->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'blog.blogs', compact('pageTitle','sections','blogs'));
    }

    public function blogDetail($id)
    {
        $pageTitle = "Blog Details";
        $blog = Frontend::where('data_keys','blog.element')->findOrFail($id);
        $blog->increment('view');
        $latests = Frontend::where('data_keys','blog.element')->orderBy('id','desc')->limit(5)->get();
        $popular = Frontend::where('data_keys','blog.element')->orderBy('view','desc')->limit(5)->get();
        return view($this->activeTemplate.'blog.details', compact('pageTitle','blog','latests','popular'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }

    public function plans()
    {
        $pageTitle = 'Plans';
        $plans = Plan::where('status',1)->get();
        return view($this->activeTemplate.'plans', compact('pageTitle','plans'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact',compact('pageTitle'));
    }


    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug,$id)
    {
        $policy = Frontend::where('id',$id)->where('data_keys','policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate.'policy',compact('policy','pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blogDetails($slug,$id){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $pageTitle = $blog->data_values->title;
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle'));
    }


    public function cookieAccept(){
        $general = GeneralSetting::first();
        Cookie::queue('gdpr_cookie',$general->site_name , 43200);
        return back();
    }

    public function cookiePolicy(){
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys','cookie.data')->first();
        return view($this->activeTemplate.'cookie',compact('pageTitle','cookie'));
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        $general = GeneralSetting::first();
        if($general->maintenance_mode == 0){
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys','maintenance.data')->first();
        return view($this->activeTemplate.'maintenance',compact('pageTitle','maintenance'));
    }

}
