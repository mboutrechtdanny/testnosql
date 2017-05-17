<?php

namespace App\Http\Controllers;

use App\Bezoeker;
use Illuminate\Http\Request;

class ConferenceEmailController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        return view('conference-email');

    }

    public function sendMail(Request $request)
    {

        $email_text = $request->get('email');

        $bezoekers = Bezoeker::pluck('email');

        foreach ($bezoekers as $bezoeker) {

            \Mail::send('emails.conference', ['email_tekst' => $email_text], function ($message) use ($bezoeker) {
                $message->from('buster@site.com', 'Buster');

                $message->to($bezoeker);
                $message->subject('Uw reservering voor de conferentie');
            });

        }

        \Session::flash('message_type', 'success');
        \Session::flash('message', 'Emails zijn verstuurd');

        return redirect('/');
    }

}
