<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/07/05
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
use App\Models\BankAccountInformation;
use App\Enums\UserRole;
use App\Mail\Admin\UserStored;

class UserService
{
    /**
     * getList
     */
    public function getList()
    {
        return User::where('role', '!=', UserRole::SystemAdmin)->orderBy('id', 'desc')->paginate(10);
    }

    /**
     * all
     */
    public function all(): \Illuminate\Database\Eloquent\Builder
    {
        $users = User::where('role', '!=', UserRole::SystemAdmin)
            // ->withTrashed()
            // ->with([
            //     // kycDocumentsが存在するか
            //     'kycDocuments' => function ($query) {
            //         $query->where('status', KycDocumentStatus::Unchecked->value);
            //     },
            // ])
        ;

        // dd($users->where('id', 50)->first());
        return $users;
    }

    /**
     * getAllCategories
     */
    public function getAllCategories()
    {
        return User::all();
    }

    /**
     * find
     */
    public function find(int $id): \App\Models\User
    {
        return User::withTrashed()->where('id', $id)->with([
            'company',
            'bankAccountInformation',
            // 'products',
            // 'orders',
        ])->first();
    }

    /**
     * create
     */
    public function store(array $request)
    {
        try {
            DB::transaction(function () use ($request, &$user) {
                $user = User::create([
                    ...$request,
                    'password' => Hash::make($request['password']),
                    'role' => $request['role'],
                    // 'is_approved' => IsApproved::Approved->value, // 承認
                ]);

                $user->assignRole($request['role']);

                // 会社情報登録
                // $this->companyRepository->create($request);
                // Company::create($request);

                // 銀行口座情報登録
                // $this->bankAccountInformationRepository->create($request);
                BankAccountInformation::create([
                    ...$request,
                    'user_id' => $user->id,
                ]);
            });

            Mail::to($user->email)->send(new UserStored($user));
        } catch (\Throwable $e) {
            logs()->error($e);
            throw $e;
        }

        return true;
    }

    /**
     * edit
     */
    public function edit(int $id)
    {
        return;
    }

    /**
     * update
     */
    public function update($request, int $userId)
    {
        try {
            DB::transaction(function () use ($request, $userId) {
                $validatedData = $request->validated();
                $user = User::where('id', $userId)->first()->fill($validatedData)->save();
                // $companyId = optional($this->userRepository->findByAdmin($userId)->company)->id;

                // // 会社情報登録
                // $companyData = [
                //     'id' => $companyId,
                //     'company_name' => $validatedData['company_name'],
                //     'representative' => $validatedData['representative'],
                // ];
                // $this->companyRepository->updateOrCreate($companyData);

                // // 銀行口座情報登録
                // $validatedData = [
                // .    ..$validatedData,
                //     'user_id' => $userId,
                // ];
                // $this->bankAccountInformationRepository->updateOrCreate($validatedData);
            });
        } catch (\Throwable $e) {
            logs()->error($e);
            throw $e;
        }

        return true;
    }

    /**
     * destroy
     */
    public function destroy(int $id)
    {
        try {
            User::where('id', $id)->delete();
        } catch (\Throwable $e) {
            logs()->error($e->getMessage());
            return redirect()->back()->with('error', 'ユーザーの削除に失敗しました。');
        }

        return true;
    }
}
