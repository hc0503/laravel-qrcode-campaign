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
     * Display a listing of the noticication.
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
}