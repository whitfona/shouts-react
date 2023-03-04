<?php

namespace App\Http\Controllers\Public\Email;

use App\Http\Controllers\Controller;
use App\Mail\ReportBeerMail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class ReportBeerController extends Controller
{
    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function __invoke(Request $request)
    {
        $data = [
            'beer_name' => $request->beer,
            'beer_id' => $request->beerId,
            'report' => $request->report
        ];

        $result = Mail::to('itsyourshoutinfo@gmail.com')->send(new ReportBeerMail($data));

        if ($result) {
            return response('Report successfully sent.', 200);
        } else {
            return response('Error sending report.', 500);
        }
    }
}
