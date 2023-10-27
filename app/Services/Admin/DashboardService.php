<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/07/05
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Services\Admin;

use App\Models\User;
// use App\Models\Product;
// use App\Models\Order;
// use App\Models\MembershipFeeReceiptsHistory;
// use App\Models\AdminTask;
// use App\Enums\OrderStatus;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class DashboardService
{
    /**
     * getUserCount
     */
    public function getUserCount(): int
    {
        return User::count();
    }

    // /**
    //  * getReceiptsBalance
    //  *
    //  * @return int
    //  */
    // public function getReceiptsBalance(): int
    // {
    //     return MembershipFeeReceiptsHistory::sum('amount');
    // }

    // /**
    //  * getOrderCount
    //  *
    //  * @return int
    //  */
    // public function getOrderCount(): int
    // {
    //     return Order::all()->count();
    // }

    // /**
    //  * getOrderPendingCount
    //  *
    //  * @return int
    //  */
    // public function getOrderPendingCount(): int
    // {
    //     return Order::where('status', '!=', OrderStatus::CompletedForReferralReward->value)->count();
    // }

    // /**
    //  * getAdminTasksTodayDue
    //  * 本日期限の担当タスクを取得する
    //  */
    // public function getAdminTasksTodayDue(): \Illuminate\Support\Collection | null
    // {
    //     return AdminTask::with(['user'])
    //         ->where('user_id', Auth::id())
    //         ->where('due_at', now()->format('Y-m-d 00:00:00'))
    //         ->where('checked_at', '=', null)
    //         ->get();
    // }
}
