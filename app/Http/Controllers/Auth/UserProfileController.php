<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/10/02
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLocation;
use App\Models\Company;
use App\Http\Requests\Admin\Profile\UpdateInformation2Request;
use App\Http\Requests\Admin\Profile\UpdateCompanyRequest;
use Inertia\Inertia;

class UserProfileController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function update(UpdateInformation2Request $request)
    {
        try {
            $validatedData = $request->validated();

            DB::transaction(function () use ($validatedData) {
                User::where('id', auth()->id())->update([
                    'sex_code' => $validatedData['sex_code'],
                    // 'age' => $validatedData['age'] ?? null,
                    'date_of_birth' => $validatedData['date_of_birth'],
                ]);

                UserLocation::updateOrCreate(['user_id' => auth()->id()], [
                    'user_id' =>  auth()->id(),
                    'phone' => $validatedData['phone'] ?? null,
                    'postal_code' => $validatedData['postal_code'] ?? null,
                    'prefecture_id' => $validatedData['prefecture_id'] ?? null,
                    'address1' => $validatedData['address1'] ?? null,
                    'address2' => $validatedData['address2'] ?? null,
                ]);
            });

            // $validatedData = $request->validate([
            //     'bank_name' => ['required', 'string', 'max:255'],
            //     'bank_branch_name' => ['required', 'string', 'max:255'],
            //     'bank_account_holder_type_code' => ['required', 'string', 'max:255'],
            //     'bank_account_number' => ['required', 'string', 'max:255'],
            //     'bank_account_holder_name' => ['required', 'string', 'max:255'],
            // ], [], [
            //     'bank_name' => '銀行名',
            //     'bank_branch_name' => '銀行支店名',
            //     'bank_account_holder_type_code' => '口座種類',
            //     'bank_account_number' => '口座番号',
            //     'bank_account_holder_name' => '口座名義',
            // ]);

            // $validatedData = [
            //      ...$validatedData,
            //     'user_id' => auth()->id(),
            // ];
        } catch (\Throwable $e) {
            logs()->error($e->getMessage());
            return redirect()->back()->withErrors(['message' => 'ユーザ情報の更新に失敗しました。']);
        }

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('message', 'ユーザーを更新しました。');
    }

    /**
     * companyUpdate
     */
    public function companyUpdate(UpdateCompanyRequest $request)
    {
        try {
            $validatedData = $request->validated();
            DB::transaction(function () use ($validatedData) {
                $company = Company::updateOrCreate(['id' => $validatedData['company_id']], $validatedData);

                User::where('id', auth()->id())->update([
                    'company_id' => $company->id,
                ]);
            });
        } catch (\Throwable $e) {
            logs()->error($e->getMessage());
            return redirect()->back()->withErrors(['message' => '企業情報の更新に失敗しました。']);
        }

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('message', '企業情報を更新しました。');
    }
}
