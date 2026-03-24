<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('administrator kan pagina voor nieuw account toevoegen openen', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMINISTRATOR,
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('accounts.create'));

    $response
        ->assertOk()
        ->assertSeeText('Nieuw account toevoegen')
        ->assertSeeText('Toevoegen');
});

test('manager kan pagina voor nieuw account toevoegen niet openen', function () {
    $manager = User::factory()->create([
        'role' => User::ROLE_MANAGER,
    ]);

    $this
        ->actingAs($manager)
        ->get(route('accounts.create'))
        ->assertForbidden();
});

test('administrator kan nieuw account succesvol toevoegen', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMINISTRATOR,
    ]);

    $response = $this
        ->actingAs($admin)
        ->post(route('accounts.store'), [
            'name' => 'nieuwaccount',
            'email' => 'nieuw-account@example.com',
            'password' => 'Welkom123!',
            'password_confirmation' => 'Welkom123!',
            'role' => User::ROLE_REISADVISEUR,
        ]);

    $response
        ->assertRedirect(route('accounts.index'))
        ->assertSessionHas('status_success', 'Het nieuwe account is succesvol toegevoegd.');

    $this->assertDatabaseHas('users', [
        'name' => 'nieuwaccount',
        'email' => 'nieuw-account@example.com',
        'role' => User::ROLE_REISADVISEUR,
    ]);

    $storedUser = User::query()->where('email', 'nieuw-account@example.com')->first();

    expect($storedUser)->not->toBeNull();
    expect(Hash::check('Welkom123!', (string) $storedUser?->password))->toBeTrue();
});

test('administrator krijgt foutmelding bij bestaande gebruikersnaam', function () {
    User::factory()->create([
        'name' => 'bestaandegebruiker',
    ]);

    $admin = User::factory()->create([
        'role' => User::ROLE_ADMINISTRATOR,
    ]);

    $response = $this
        ->actingAs($admin)
        ->from(route('accounts.create'))
        ->post(route('accounts.store'), [
            'name' => 'bestaandegebruiker',
            'email' => 'ander@example.com',
            'password' => 'Welkom123!',
            'password_confirmation' => 'Welkom123!',
            'role' => User::ROLE_REISADVISEUR,
        ]);

    $response
        ->assertRedirect(route('accounts.create'))
        ->assertSessionHasErrors([
            'name' => 'Probeer een ander gebruiksnaam toe toevoegen.',
        ]);

    $this->assertDatabaseMissing('users', [
        'email' => 'ander@example.com',
    ]);
});

test('manager kan nieuw account niet toevoegen', function () {
    $manager = User::factory()->create([
        'role' => User::ROLE_MANAGER,
    ]);

    $this
        ->actingAs($manager)
        ->post(route('accounts.store'), [
            'name' => 'verboden-account',
            'email' => 'verboden@example.com',
            'password' => 'Welkom123!',
            'password_confirmation' => 'Welkom123!',
            'role' => User::ROLE_REISADVISEUR,
        ])
        ->assertForbidden();
});
