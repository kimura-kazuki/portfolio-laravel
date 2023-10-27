<?php

/**
 * @copyright   kimura kazuki. All Rights Reserved.
 * @since       2023/10/26
 * @author      Kazuki Kimura <kidsc0me@gmail.com>
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Http\Validators\ExtensionValidator;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::resolver(function ($translator, $data, $rules, $messages, $attributes) {
            return new ExtensionValidator($translator, $data, $rules, $messages, $attributes);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
