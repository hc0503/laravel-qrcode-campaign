<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CampaignHit;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    // Default pageConfig
    protected $pageConfigs = [
        'navbarType' => 'sticky',
        'footerType' => 'sticky'
    ];

    /**
     * User dashboard
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userDashboard(Request $request)
    {
        $campaigns = Auth::user()->campaigns;
        $campaignHits = CampaignHit::all();
        $campaignHitCounts = array();

        foreach ($campaigns as $campaign) {
            array_push($campaignHitCounts, $campaign->campaignHits()->count());
        }
        
        return view('/pages/dashboard', [
            'pageConfigs' => $this->pageConfigs,
            'campaignNames' => $campaigns->pluck('campaign_name'),
            'campaignHitCounts' => json_encode($campaignHitCounts),
            'campaignHits' => $campaignHits
        ]);
    }

    /**
     * Get coordinates of QR code hitmap
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCoordinates(Request $request)
    {
        $type = $request->type;
        
        if ($type == 'today') {
            $data = CampaignHit::whereDate('created_at', '=', Carbon::today()->toDateString())
                ->whereHas('campaign', function($query) {
                    $query->where('user_id', Auth::user()->id);
                })
                ->get();
        } else if ($type == 'week') {
            $data = CampaignHit::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->whereHas('campaign', function($query) {
                    $query->where('user_id', Auth::user()->id);
                })
                ->get();
        } else if ($type == 'month') {
            $data = CampaignHit::whereMonth('created_at', '=', Carbon::now()->month)
                ->whereHas('campaign', function($query) {
                    $query->where('user_id', Auth::user()->id);
                })
                ->get();
        } else {
            $data = CampaignHit::whereHas('campaign', function($query) {
                    $query->where('user_id', Auth::user()->id);
                })
                ->get();
        }

        return new JsonResponse($data);
    }

}

