<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CampaignHit;

class DashboardController extends Controller
{
    // Default pageConfig
    protected $pageConfigs = [
        'navbarType' => 'sticky',
        'footerType' => 'sticky'
    ];

    // Dashboard - Analytics
    public function dashboardAnalytics(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/dashboard-analytics', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    /**
     * User dashboard
     * 
     * @return \Illuminate\Http\Response
     */
    public function userDashboard()
    {
        $campaigns = Auth::user()->campaigns;
        $campaignHits = CampaignHit::all();

        return view('/pages/dashboard', [
            'pageConfigs' => $this->pageConfigs,
            'campaigns' => $campaigns,
            'campaignHits' => $campaignHits
        ]);
    }

}

