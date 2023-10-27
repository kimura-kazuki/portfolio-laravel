<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/02/09
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\Team;
use App\Models\User;
use App\Models\Company;
use App\Models\UserLocation;
use App\Enums\UserRole;
use App\Enums\Sex;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * @param array|\Spatie\Permission\Contracts\Role|string  ...$roles
     * @return UserFactory
     * NOTE: https://abartelt.medium.com/laravel-8-user-factory-with-role-states-1d93a7521800
     */
    private function assignRole(...$roles): UserFactory
    {
        return $this->afterCreating(fn(User $user) => $user->syncRoles($roles));
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (User $user) {
            // default user role
            return $user->assignRole('staff');
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'name_kana' => $this->faker->kanaName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'phone' => $this->faker->phoneNumber(),
            'sex_code' => $this->faker->randomElement([Sex::Male->value, Sex::Female->value]), // 1 or 2
            // 'age' => $this->faker->numberBetween(20, 100),
            'date_of_birth' => $this->faker->date(),
            // 'is_approved' => IsApproved::Approved->value, // 承認
            // 'is_agreed' => 1, // 同意
            'created_by' => 1,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name . '\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }

    /**
    * システム管理者
    *
    * @return UserFactory
    */
    public function systemAdmin(): UserFactory
    {
        return $this->state(fn ()  => [
            // 'membership_number' => \Sequence::getNewUserNo('system admin'),
            'role' => UserRole::SystemAdmin->value,
        ])->assignRole('system admin');
    }

    /**
     * 運営者
     *
     * @return UserFactory
     */
    public function admin(): UserFactory
    {
        return $this
            // ->has(UserReferralCode::factory(1))
            ->state(fn ()  => [
                // 'membership_number' => \Sequence::getNewUserNo('admin'),
                'role' => UserRole::Admin->value,
            ])
            ->assignRole('admin')
        ;
    }

    /**
     * スタッフ
     *
     * @return UserFactory
     */
    public function staff(): UserFactory
    {
        return $this
            ->has(UserLocation::factory(1))
            // ->has(UserReferralCode::factory(1))
            ->state(
                fn (array $attributed)  => [
                    // 'introducer_code' => UserReferralCode::get()->random()->referral_code,
                    'company_id' => Company::get()->random()->id,
                ]
            )
            ->state(fn ()  => [
                // 'membership_number' => \Sequence::getNewUserNo('customer'),
                'role' => UserRole::Staff->value,
            ])
            ->assignRole('staff')
        ;
    }
}
