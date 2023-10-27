<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/08/23
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Actions\Admin\User;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\BankAccountInformation;
use App\Mail\Admin\UserStored;

class StoreAction
{
    public function __invoke(?User $user, array $request): User
    {
        // バグを防ぐために簡易的にアサーションを書く
        assert($user->exists);

        DB::transaction(function () use (&$user, $request) {
            $user->save();

            $user->assignRole($user->role);

            // 会社情報登録
            // $this->companyRepository->create($request);
            // Company::create($request);

            // 銀行口座情報登録
            // $this->bankAccountInformationRepository->create($request);
            BankAccountInformation::create([
                ...$request,
                'user_id' => $user->id,
            ]);

            // // 紹介コード登録
            // UserReferralCode::create([
            //     'user_id' => $user->id,
            //     'referral_code' => Str::random(10),
            // ]);
        });

        Mail::to($user->email)->send(new UserStored($user));

        return $user;
    }
}
