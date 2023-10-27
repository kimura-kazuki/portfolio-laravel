<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/10/03
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BankAccountInformation;
use App\Enums\BankAccountHolderTypeCode;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class UpdateIntroducerCodeController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'introducer_code' => ['required', 'string', 'max:255'],
            ], [], [
                'introducer_code' => '紹介者コード',
            ]);

            User::where('id', auth()->id())->update([
                'introducer_code' => $validatedData['introducer_code'],
            ]);
        } catch (\Throwable $e) {
            logs()->error($e->getMessage());
            return redirect()->back()->withErrors(['message' => '紹介者コードの更新に失敗しました。']);
        }

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'profile-information-updated');
    }
}
