<?php

it('can see admin dashboard page', function () {
    $response = $this->post('/login', [
        'email' => 'kidsc0me@gmail.com',
        'password' => '1234qwer',
    ]);

    // config/fortify.phpの'home' => RouteServiceProvider::HOME,を参照しているので、/dashboardにリダイレクトされる。
    $response->assertRedirect('/dashboard');
});
