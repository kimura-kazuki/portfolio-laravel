<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/09/25
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserStoreRequest;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use App\Http\Requests\Admin\User\IsApprovedUpdateRequest;
use App\Http\Requests\Admin\User\CompanyUpdateRequest;
use App\Http\Requests\Admin\User\BankAccountUpdateRequest;
use App\Http\Requests\Admin\User\UserReferralCodeUpdateRequest;
use App\Http\Resources\UserCollection;
use App\Actions\Admin\User\StoreAction;
use App\Actions\Admin\User\Exceptions\UserLimitExceededException;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\RoleType;
use App\Enums\Sex;
// use App\Enums\IsApproved;
use App\Enums\BankAccountHolderTypeCode;
// use App\Enums\KycDocumentStatus;
use App\Services\Admin\UserService;
use Inertia\Inertia;
use App\Traits\InertiaTable\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
                // ->column('created_at_formated', '作成日', searchable: true, sortable: true)
                // ->column('membership_number', '会員番号', searchable: true, sortable: true)
                ->column('name', '名前', searchable: true, sortable: true)
                ->column('email', 'メールアドレス', searchable: true, sortable: true, hidden: true)
                ->column('sex_label', '性別', searchable: false, sortable: false)
                ->column('role_label', '会員種別', searchable: false, sortable: false)
                // ->column('is_approved_label', '承認', searchable: false, sortable: false)
                // ->column('deleted_at_formated', '削除日', searchable: false, sortable: true)
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
            // $userCompany = $user->company()->get();
            $userCompany = $user->company;

            // 性別Enum取得
            $sexOptions = collect(Sex::cases())->map(
                fn($item) => [
                    'value' => $item->value,
                    'name' => $item->label(),
                ]
            )->toArray();

            // // 承認状況Enum取得
            // $isApprovedOptions = collect(IsApproved::cases())->map(
            //     fn($item) => [
            //         'value' => $item->value,
            //         'name' => $item->label(),
            //     ]
            // )->toArray();

            // 口座種別Enum取得
            $bankAccountHolderTypeCodeOptions = collect(BankAccountHolderTypeCode::cases())->map(
                fn($item) => [
                    'value' => $item->value,
                    'name' => $item->label(),
                ]
            )->toArray();

            // // 無料会員紹介コード
            // $userReferralCode = $this->userService->getUserReferralCode($userId);
            // // $qrCode = QrCode::format('png')->size(100)->generate(route('register').'?code='.$userReferralCode);
            // $customerUserReferralUrl = route('register').'?code='.$userReferralCode;
            // $customerUserQrCodeUrl = (!empty($userReferralCode))
            //     ? 'https://chart.apis.google.com/chart?chs=150x150&cht=qr&chl='.$customerUserReferralUrl
            //     : '';

            // // 加盟店紹介コード
            // $userReferralCode = $this->userService->getUserReferralCode($userId);
            // // $qrCode = QrCode::format('png')->size(100)->generate(route('register').'?code='.$userReferralCode);
            // $advertiserUserReferralUrl = route('register-advertiser').'?code='.$userReferralCode;
            // $advertiserUserQrCodeUrl = (!empty($userReferralCode))
            //     ? 'https://chart.apis.google.com/chart?chs=150x150&cht=qr&chl='.$advertiserUserReferralUrl
            //     : '';

            // // 紹介者（親）
            // $userIntroducer = $this->userService->getIntroducer($userId);

            // // 紹介者（子）
            // $referredUsers = $this->userService->getReferredUsers($userId, 10);

            // // 紹介料支払履歴
            // $userPaymentHistories = $this->userService->getPaymentHistories($userId, 5);
            // $userPaymentHistoriesSum = $this->userService->getPaymentHistoriesSum($userId);

            // // ポイント支払履歴
            // $userPointHistories = $this->userService->getPointHistories($userId, 5);
            // $userPointHistoriesSum = $this->userService->getPointHistoriesSum($userId);

            // // 加盟料入金履歴
            // $userReceiptsHistories = $this->userService->getReceiptsHistories($userId, 5);
            // $userReceiptsHistoriesSum = $this->userService->getReceiptsHistoriesSum($userId);

            // // 1つ以上の本人確認書類の提出が存在するか
            // $isKycDocumentsExists = $this->userService->checkKycDocumentsExists($userId);

            // // 未確認の本人確認書類が存在するか
            // $isUncheckedKycDocumentsExists = $this->userService->checkUncheckedKycDocumentsExists($userId);
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
            // 'isApprovedOptions',
            'bankAccountHolderTypeCodeOptions',
            // 'userReferralCode',
            // 'userIntroducer',
            // 'referredUsers',
            // 'userPaymentHistories',
            // 'userPaymentHistoriesSum',
            // 'userPointHistories',
            // 'userPointHistoriesSum',
            // 'userReceiptsHistories',
            // 'userReceiptsHistoriesSum',
            // 'customerUserQrCodeUrl',
            // 'advertiserUserQrCodeUrl',
            // 'isKycDocumentsExists',
            // 'isUncheckedKycDocumentsExists',
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

            // // 承認状況Enum取得
            // $isApprovedOptions = collect(IsApproved::cases())->map(
            //     fn($item) => [
            //         'value' => $item->value,
            //         'name' => $item->label(),
            //     ]
            // )->toArray();

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
