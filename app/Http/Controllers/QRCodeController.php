<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\CampaignHit;
use Illuminate\Support\Facades\Http;

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

        $image = \QrCode::format('png');

        $image = $image->size(300)
            ->errorCorrection('H')
            ->color($this->convertRGB($campaign->foreground)[0], $this->convertRGB($campaign->foreground)[1], $this->convertRGB($campaign->foreground)[2])
            ->backgroundColor($this->convertRGB($campaign->background)[0], $this->convertRGB($campaign->background)[1], $this->convertRGB($campaign->background)[2]);

        if ($campaign->logo != null) {
            $image = $image->merge(asset("storage/" . $campaign->logo), 0.4, true);
        }

        $image = $image->generate($url);
        return response($image)->header('Content-type','image/png');
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
