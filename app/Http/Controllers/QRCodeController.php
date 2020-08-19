<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\CampaignHit;
use Illuminate\Support\Facades\Http;

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
        $qrCode = new QrCode($url);
        $qrCode->setSize(400);
        $qrCode->setMargin(10);

        $qrCode->setWriterByName('png');
        $qrCode->setEncoding('UTF-8');
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
        $qrCode->setForegroundColor(['r' => $this->convertRGB($campaign->foreground)[0]
                                , 'g' => $this->convertRGB($campaign->foreground)[1]
                                , 'b' => $this->convertRGB($campaign->foreground)[2], 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => $this->convertRGB($campaign->background)[0]
                                , 'g' => $this->convertRGB($campaign->background)[1]
                                , 'b' => $this->convertRGB($campaign->background)[2], 'a' => 0]);

        if ($campaign->logo != null) {
          $qrCode->setLogoPath(asset("storage/" . $campaign->logo));
          $qrCode->setLogoSize(150, 150);
        }
        $qrCode->setValidateResult(false);
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_MARGIN); // The size of the qr code is shrinked, if necessary, but the size of the final image remains unchanged due to additional margin being added (default)
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_ENLARGE); // The size of the qr code and the final image is enlarged, if necessary
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_SHRINK); // The size of the qr code and the final image is shrinked, if necessary

        $qrCode->setWriterOptions(['exclude_xml_declaration' => true]);

        return response($qrCode->writeString())->header('Content-Type: ', $qrCode->getContentType());
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
