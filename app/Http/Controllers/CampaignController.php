<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CampaignController extends Controller
{
    // Default pageConfig
    protected $pageConfigs = [
        'navbarType' => 'sticky',
        'footerType' => 'static'
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
            ['link'=>"",'name'=>trans('locale.campaign.title')], ['name'=>trans('locale.campaign.list')]
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
            ['link'=>"",'name'=>trans('locale.campaign.title')], ['name'=>trans('locale.campaign.create')]
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
        $validator = $request->validate([
            'campaign_name' => 'required|string|max:190',
            'url' => "required|url",
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $campaign = $request->user()->campaigns()->create([
            'campaign_name' => $request->campaign_name,
            'url' => $request->url,
            'foreground' => $request->foreground,
            'background' => $request->background,
            'logo' => $logoPath
        ]);

        return redirect()
            ->route('campaigns.show', $campaign->id)
            ->with('message', trans('locale.campaign.saveSuccess'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        $breadcrumbs = [
            ['link'=>"",'name'=>trans('locale.campaign.title')], ['name'=>trans('locale.campaign.view')]
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
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return redirect()
            ->route('campaigns.index')
            ->with('message', trans('locale.campaign.deleteSuccess'));
    }

    /**
     * Remove the specified resource from storage via ajax.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxDelete(Request $request)
    {
        $campaign = Campaign::findOrfail($request->campaign_id);
        $campaign->delete();

        return new JsonResponse(null, 204);
    }
}
