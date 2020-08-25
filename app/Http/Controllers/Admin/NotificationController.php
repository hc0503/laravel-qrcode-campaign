<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
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

    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link'=>"/admin/notifications", 'name'=>trans('locale.notification.title')], ['name'=>trans('locale.notification.list')]
        ];
        $notifications = Notification::all();

        return view('/pages/admin/notifications/index', [
            'pageConfigs' => $this->pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'notifications' => $notifications
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
            ['link'=>"/admin/notifications",'name'=>trans('locale.notification.title')], ['name'=>trans('locale.notification.create')]
        ];
        
        return view('/pages/admin/notifications/create', [
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
        $this->validate($request, [
            'title'=>'required|max:90',
            'text'=>'required|max:190',
            'status'=>'required'
        ]);

        $user = Notification::create($request->all());

        return redirect()->route('notifications.index')
            ->with('message', trans('locale.notification.message.save'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Spatie\Permission\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        $breadcrumbs = [
            ['link'=>"/admin/notifications",'name'=>trans('locale.notification.title')], ['name'=>trans('locale.notification.edit')]
        ];
        
        return view('/pages/admin/notifications/edit', [
            'pageConfigs' => $this->pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'notification' => $notification
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        $this->validate($request, [
            'title'=>'required|max:90',
            'text'=>'required|max:190',
            'status'=>'required'
        ]);

        $notification->update($request->all());
        
        return redirect()->route('notifications.index')
            ->with('message', trans('locale.notification.message.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()
            ->route('notifications.index')
            ->with('message', trans('locale.notification.message.delete'));
    }

    /**
     * Set notification status, default status is 1.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setStatus(Request $request)
    {
        $notification = Notification::findOrfail($request->notification_id);
        $notification->status = $request->state;
        $notification->save();

        return new JsonResponse(null, 204);
    }
}