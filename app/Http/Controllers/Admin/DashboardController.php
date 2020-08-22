<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Campaign;
use App\Models\CampaignHit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Default pageConfig
    protected $pageConfigs = [
        'navbarType' => 'sticky',
        'footerType' => 'static',
        'mainLayoutType' => 'horizontal',
        'horizontalMenuType' => 'floating',
        'theme' => 'dark',
        'navbarColor' => 'bg-primary'
    ];

    public function __construct() {
        // $this->middleware(['auth', 'isAdmin']);//isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Admin dashboard
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adminDashboard(Request $request)
    {
        $campaignHits = CampaignHit::all();
        $campaigns = Campaign::all();
        // $count = Campaign::select('created_at', DB::raw('count(*) as total'))
        //     ->groupBy(function($val) {
        //         return Carbon::parse($val->created_at)->format('d');
        //     })->orderBy('created_at')->value('total');

        $query = DB::select(DB::raw("SELECT COUNT(*) count, DATE(created_at) dt FROM campaigns GROUP BY DATE(created_at) ORDER BY DATE(created_at);"));
        $compaigns_values = array();
        foreach ($query as $one)
        {
            array_push($compaigns_values, $one->count);
        }

        $query = DB::select(DB::raw("SELECT COUNT(*) count, DATE(created_at) dt FROM campaign_hits GROUP BY DATE(created_at) ORDER BY DATE(created_at);"));
        $compaignhits_values = array();
        foreach ($query as $one)
        {
            array_push($compaignhits_values, $one->count);
        }

        $query = DB::select(DB::raw("
            SELECT b.count FROM campaigns AS a
            LEFT JOIN (
                SELECT campaign_id, COUNT(campaign_id) AS COUNT FROM campaign_hits GROUP BY campaign_id
                ) AS b ON a.id = b.campaign_id ORDER BY a.id
        "));
        $scanned_values = array();
        foreach ($query as $one)
        {
            if (!isset($one->count))
                array_push($scanned_values, 0);
            else
                array_push($scanned_values, $one->count);
        }

        return view('/pages/admin/dashboard', [
            'pageConfigs' => $this->pageConfigs,
            'campaigns' => $campaigns,
            'campaignHits' => $campaignHits,
            'compaigns_values' => json_encode($compaigns_values),
            'compaignhits_values' => json_encode($compaignhits_values),
            'scanned_values' => json_encode($scanned_values)
        ]);
    }
}
