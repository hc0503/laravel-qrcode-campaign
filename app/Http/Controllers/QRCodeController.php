<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\CampaignHit;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

class QRCodeController extends Controller
{
    // IP track access key
    protected $accessKey = '1a16715ccd10b1c6e5e4d5636890f51d';

    /**
     * This generates QR code image from campaign id.
     *
     * @param \App\Models\Campaign  $campaign
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateQRCode(Campaign $campaign, Request $request)
    {
        $url = route('qrcode-track', $campaign);
        $cmd = "";
        $logo = "";
        $output = "";
        if(env('APP_DEBUG') == 'true') {
            $myfile = fopen("/app/storage/logs/qrlogs.log", "a") or die("Unable to open file!");
        }
        if ($campaign->logo != null) {
          $logo = "/app/public/storage/" . $campaign->logo;
          $cmd = escapeshellcmd("/app/qrgen.py " . $url . " --fg " . $campaign->foreground . " --bg " . $campaign->background . " --output /app/public/storage/qrs/" . " --logo " . $logo);
        }
        else {
          $cmd = escapeshellcmd("/app/qrgen.py " . $url . " --fg " . $campaign->foreground . " --bg " . $campaign->background . " --output /app/public/storage/qrs/");
        }
        $output = system($cmd);
        echo "OUT IS: $output and cmd is $cmd\n";
        if(env('APP_DEBUG') == 'true') {
            fwrite($myfile, "$output" . "OUTPUT:$cmd\n");
        }
        return response()->json(['success' => $output], 200);
    //     return response($qrCode->writeString())->header('Content-Type: ', $qrCode->getContentType());
    }

    /**
     * User info track and return QR code url
     *
     * @param \App\Models\Campaign  $campaign
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function qrCodeTrack(Campaign $campaign, Request $request)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $ipTrackURL = 'https://api.ipstack.com/' . $ip . '?access_key=' . $this->accessKey;
        $trackResponse = json_decode(https::get($ipTrackURL));

        $campaign->campaignHits()->create([
            'latitude' => $trackResponse->latitude,
            'longitude' => $trackResponse->longitude,
            'location' => $trackResponse->continent_name . '/' . $trackResponse->city . '/' . $trackResponse->zip,
            'browser' => $_SERVER['HTTP_USER_AGENT']
        ]);

        return Redirect::to($campaign->url);
    }

    /**
     * convert hex color value to rgb color
     *
     * @param String  $hexValue
     * @return Array  $arrayRGB
     */
    public function convertRGB($hexValue)
    {
        $arrayRGB = [];

        $hexValue = str_replace("#", "", $hexValue);
        $split_hex_color = str_split($hexValue, 2);
        $rgb1 = hexdec($split_hex_color[0]);
        $rgb2 = hexdec($split_hex_color[1]);
        $rgb3 = hexdec($split_hex_color[2]);

        array_push($arrayRGB, $rgb1, $rgb2, $rgb3);

        return $arrayRGB;
    }
}
