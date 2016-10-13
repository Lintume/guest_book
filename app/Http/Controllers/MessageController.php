<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Message;


class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all();
        return view('index', ['messages'=>$messages]);
    }

    public function saveMessage(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'g-recaptcha-response' => 'required|captcha',
            'text' => 'required'
        ]);
        $data = $request->all();
        $data['IP'] = $request->ip();
        $data['browser'] = $request->server('HTTP_USER_AGENT');

        if ($request->file('input-file'))
        {
            $file = $request->file('input-file');
            $extension = $file->guessExtension();
            $randomString = str_random(5);
            $nameFromHash = sha1($file->getClientOriginalName());
            $newFileName = $nameFromHash . $randomString . '.' . $extension;
            $path = public_path('uploads');
            $file->move($path, $newFileName);

            $data['file'] = $newFileName;
        }
        Message::create($data);
        return redirect('/');
    }

    public function returnTXT(Request $request)
    {
        return file_get_contents($request->url);
    }
}
