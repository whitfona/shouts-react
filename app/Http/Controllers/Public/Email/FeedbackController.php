<?php

namespace App\Http\Controllers\Public\Email;

use App\Http\Controllers\Controller;
use App\Mail\FeedbackMail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function __invoke(Request $request)
    {
        $data = [
            'message' => $request->message,
        ];

        $result = Mail::to('itsyourshoutinfo@gmail.com')->send(new FeedbackMail($data));

        if ($result) {
            return response('Report successfully sent.', 200);
        } else {
            return response('Error sending report.', 500);
        }
    }
}
