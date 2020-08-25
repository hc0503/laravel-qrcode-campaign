<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

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
}