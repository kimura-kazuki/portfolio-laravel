<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/09/25
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserStoreRequest;
use App\Http\Resources\UserCollection;
use App\Actions\Admin\User\StoreAction;
use App\Actions\Admin\User\Exceptions\UserLimitExceededException;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\RoleType;
use App\Enums\Sex;
use App\Enums\BankAccountHolderTypeCode;
use App\Services\Admin\UserService;
use Inertia\Inertia;
use App\Traits\InertiaTable\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private UserService $userService,
    ) {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * index
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        /**
         * laravel datatabeles
         */
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });
        $users = QueryBuilder::for($this->userService->all())
            // ->withTrashed()
            ->defaultSort('-id')
            ->allowedSorts(['id', 'name', 'email', 'sex_label', 'role_label', 'is_approved_label'])
            ->allowedFilters(['name', 'email', 'sex_label', 'role', 'is_approved', $globalSearch])
            ->paginate($request->perPage ?? 10)
            ->withQueryString()
        ;

        return Inertia::render(
            'Admin/Users/Index',
            compact('users')
        )->table(function (InertiaTable $table) {
            $table
                ->column('id', 'ID', searchable: true, sortable: true)
                ->column('name', '名前', searchable: true, sortable: true)
                ->column('email', 'メールアドレス', searchable: true, sortable: true, hidden: true)
                ->column('sex_label', '性別', searchable: false, sortable: false)
                ->column('role_label', '会員種別', searchable: false, sortable: false)
                ->column(label: '参照', canBeHidden: false)
                ->column(label: '編集', canBeHidden: false)
                ->column(label: '削除', canBeHidden: false)
                ->withGlobalSearch('「名前」「メールアドレス」からあいまい検索')
                ->selectFilter(key: 'role', label: '会員種別', options: [
                    UserRole::Admin->value => UserRole::Admin->label(),
                    UserRole::Staff->value => UserRole::Staff->label(),
                ])
            ;
        });
    }

    /**
     * show
     */
    public function show(int $userId)
    {
        try {
            $user = $this->userService->find($userId);
            $userBank = $user->bankAccountInformation()->first();
            $userCompany = $user->company;

            // 性別Enum取得
            $sexOptions = collect(Sex::cases())->map(
                fn($item) => [
                    'value' => $item->value,
                    'name' => $item->label(),
                ]
            )->toArray();

            // 口座種別Enum取得
            $bankAccountHolderTypeCodeOptions = collect(BankAccountHolderTypeCode::cases())->map(
                fn($item) => [
                    'value' => $item->value,
                    'name' => $item->label(),
                ]
            )->toArray();
        } catch (\Throwable $e) {
            logs()->error($e->getMessage());
            return redirect()->back()->withErrors(['message' => 'ユーザー情報の取得に失敗しました。']);
        }

        return Inertia::render('Admin/Users/Show', compact(
            'userId',
            'user',
            'userBank',
            'userCompany',
            'sexOptions',
            'bankAccountHolderTypeCodeOptions',
        ));
    }

    /**
     * create
     */
    public function create()
    {
        try {
            // 性別Enum取得
            $sexOptions = collect(Sex::cases())->map(
                fn($item) => [
                    'value' => $item->value,
                    'name' => $item->label(),
                ]
            )->toArray();

            // 口座種別Enum取得
            $bankAccountHolderTypeCodeOptions = collect(BankAccountHolderTypeCode::cases())->map(
                fn($item) => [
                    'value' => $item->value,
                    'name' => $item->label(),
                ]
            )->toArray();

            $userRoles = RoleType::asSelectArray();
            $userRoles = Arr::except($userRoles, ['system admin']);
        } catch (\Throwable $e) {
            logs()->error($e->getMessage());
            return redirect()->back()->withErrors(['message' => 'カテゴリーの取得に失敗しました。']);
        }

        return Inertia::render('Admin/Users/Create', compact(
            'sexOptions',
            // 'isApprovedOptions',
            'bankAccountHolderTypeCodeOptions',
            'userRoles',
        ));
    }

    /**
     * store
     */
    public function store(UserStoreRequest $request, StoreAction $action)
    {
        $user = $request->makeUser();

        try {
            return new UserCollection($action($user, $request->validated()));
        } catch (\Throwable $e) {
            logs()->error($e->getMessage());
            // 捕まえた例外はスタックトレースに積む
            // throw new TooManyRequestsHttpException(null, $e->getMessage(), $e);
            return $request->wantsJson()
                ? new JsonResponse('', 500)
                : back()->withErrors(['message' => 'LINEアカウントの追加に失敗しました。']);
        }
    }
}
