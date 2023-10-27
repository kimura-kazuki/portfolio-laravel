<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/08/09
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
// use App\Enums\IsApproved;
use App\Services\Admin\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
    ) {
        //
    }

    /**
     * index
     */
    public function index()
    {
        $isAdmin = Gate::allows('admin');
        $canLogin = Route::has('login');
        $canRegister = Route::has('register');

        $userCount = number_format($this->dashboardService->getUserCount());

        return Inertia::render('Admin/Dashboard', compact(
            'isAdmin',
            'canLogin',
            'canRegister',
            'userCount',
        ));
    }
}
