<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    // Default pageConfig
    protected $pageConfigs = [
        'navbarType' => 'sticky',
        'footerType' => 'sticky'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Auth::user()->campaigns;
        $breadcrumbs = [
            ['link'=>"",'name'=>trans('locale.Campaigns')], ['name'=>trans('locale.CampaignList')]
        ];
        return view('/pages/campaigns/index', [
            'pageConfigs' => $this->pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'campaigns' => $campaigns
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link'=>"",'name'=>trans('locale.Campaigns')], ['name'=>trans('locale.CreateCampaign')]
        ];

        return view('/pages/campaigns/create', [
            'pageConfigs' => $this->pageConfigs,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regex = '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:.\d{1,3}){3})(?!(?:169.254|192.168)(?:.\d{1,3}){2})(?!172.(?:1[6-9]|2\d|3[0-1])(?:.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]-)[a-z\x{00a1}-\x{ffff}0-9]+)(?:.(?:[a-z\x{00a1}-\x{ffff}0-9]-)[a-z\x{00a1}-\x{ffff}0-9]+)(?:.(?:[a-z\x{00a1}-\x{ffff}]{2,})).?)(?::\d{2,5})?(?:[/?#]\S)?$_iuS';
        $validator = Validator::make($request->all(), [
            'campaign_name' => 'required|string|max:190',
            'url' => "required",
        ]);

        $campaign = $request->user()->campaigns()->create(
            $request->all()
        );

        $breadcrumbs = [
            ['link'=>"",'name'=>trans('locale.Campaigns')], ['name'=>trans('locale.ViewCampaign')]
        ];

        return redirect()
            ->route('campaigns.show', $campaign->id)
            ->with('message', trans('locale.saveSuccess'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        $breadcrumbs = [
            ['link'=>"",'name'=>trans('locale.Campaigns')], ['name'=>trans('locale.ViewCampaign')]
        ];
        return view('/pages/campaigns/view', [
            'pageConfigs' => $this->pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'campaign' => $campaign
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
