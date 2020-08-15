<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\CampaignHit;
use LaravelQRCode\Facades\QRCode;
use Illuminate\Support\Facades\Http;

class QRCodeController extends Controller
{
    // IP track access key
    protected $accessKey = '1a16715ccd10b1c6e5e4d5636890f51d';

    /**
     * This generates QR code image from campaign id.
     * 
     * @param \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function generateQRCode(Campaign $campaign)
    {
        $url = route('qrcode-track', $campaign);
        return QRCode::text($url)->png();
    }

    /**
     * User info track and return QR code url
     * 
     * @param \App\Models\Campaign  $campaign
     * @return String  $string
     */
    public function qrCodeTrack(Campaign $campaign)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $ipTrackURL = 'http://api.ipstack.com/' . $ip . '?access_key=' . $this->accessKey;
        $trackResponse = json_decode(Http::get($ipTrackURL));

        $campaign->campaignHits()->create([
            'latitude' => $trackResponse->latitude,
            'longitude' => $trackResponse->longitude,
            'location' => $trackResponse->continent_name . '/' . $trackResponse->city . '/' . $trackResponse->zip,
            'browser' => $_SERVER['HTTP_USER_AGENT']
        ]);

        return $campaign->url;
    }
}
