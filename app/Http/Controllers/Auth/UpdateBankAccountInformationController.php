<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/10/02
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

class UpdateBankAccountInformationController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        try {
            $bankAccountHolderTypeCodeValues = collect(BankAccountHolderTypeCode::cases())->map(fn ($item) => $item->value)->join(',');
            $validatedData = $request->validate([
                'bank_name' => ['required', 'string', 'max:255'],
                'bank_branch_name' => ['required', 'string', 'max:255'],
                'bank_account_holder_type_code' => ['required', 'string', 'in:' . $bankAccountHolderTypeCodeValues],
                'bank_account_number' => ['required', 'string', 'max:255'],
                'bank_account_holder_name' => ['required', 'string', 'max:255'],
            ], [], [
                'bank_name' => '銀行名',
                'bank_branch_name' => '銀行支店名',
                'bank_account_holder_type_code' => '性別',
                'bank_account_number' => '銀行番号',
                'bank_account_holder_name' => '口座名義',
            ]);

            BankAccountInformation::updateOrCreate(
                ['user_id' => auth()->user()->id],
                [
                    'bank_name' => $validatedData['bank_name'],
                    'bank_branch_name' => $validatedData['bank_branch_name'],
                    'bank_account_holder_type_code' => $validatedData['bank_account_holder_type_code'],
                    'bank_account_number' => $validatedData['bank_account_number'],
                    'bank_account_holder_name' => $validatedData['bank_account_holder_name'],
                ]
            );
        } catch (\Throwable $e) {
            logs()->error($e->getMessage());
            return redirect()->back()->withErrors(['message' => '銀行口座情報の更新に失敗しました。']);
        }

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'profile-information-updated');
    }
}
