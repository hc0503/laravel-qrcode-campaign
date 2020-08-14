<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use LaravelQRCode\Facades\QRCode;

class QRCodeController extends Controller
{
    /**
     * This generates QR code image from campaign id.
     * 
     * @param \App\Models\Campaign  $campaign
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateQRCode(Campaign $campaign, Request $request)
    {
        return QRCode::text($campaign->url)->png();
    }
}
