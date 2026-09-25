<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin stays logged in after login', function () {
    $user = User::factory()->create(['password' => 'secret']);

    $this->get(backpack_url('login'));
    $this->post(backpack_url('login'), [
        '_token' => csrf_token(),
        'email' => $user->email,
        'password' => 'secret',
    ])->assertRedirect(backpack_url('dashboard'));

    $this->get(backpack_url('dashboard'))->assertOk();
});

test('admin is logged out after the password changes in another session', function () {
    $user = User::factory()->create(['password' => 'secret']);

    $this->get(backpack_url('login'));
    $this->post(backpack_url('login'), [
        '_token' => csrf_token(),
        'email' => $user->email,
        'password' => 'secret',
    ]);

    $user->forceFill(['password' => 'changed'])->save();
    auth()->forgetGuards();

    $this->get(backpack_url('dashboard'))->assertRedirect(backpack_url('login'));
});
