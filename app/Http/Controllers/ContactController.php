<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactMeRequest;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{

    public function showForm(){
        return view('blog.contact');
    }

    public function sendContactInfo(ContactMeRequest $request){
        $data = $request->only('name','phone','email');
        $data['messageLines'] = explode('\n',$request->get('message'));
        Mail::to($data['email'])->queue3(new ContactMail($data));
        return back()
            ->with("success", "消息已发送，感谢您的反馈");
    }
}
