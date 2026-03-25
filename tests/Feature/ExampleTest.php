<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

test('de homepagina wordt geladen wanneer de website beschikbaar is', function () {
    $response = $this->get('/');

    $response->assertOk();
});

test('de browser ziet een onderhoudsmelding wanneer de website in onderhoud is', function () {
    $this->artisan('down');

    try {
        $response = $this->get('/');

        $response
            ->assertStatus(503)
            ->assertSeeText('De website is nog in onderhoud.');
    } finally {
        $this->artisan('up');
    }
});

test('de gebruiker kan succesvol inloggen met e-mail en ziet een succesmelding', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Welkom123!'),
    ]);

    $response = $this->post('/login', [
        'login' => $user->email,
        'password' => 'Welkom123!',
    ]);

    $response
        ->assertRedirect('/')
        ->assertSessionHas('status_success', 'Succesvol ingelogd.');

    $this->assertAuthenticatedAs($user);
});

test('de gebruiker kan succesvol inloggen met gebruikersnaam', function () {
    $user = User::factory()->create([
        'name' => 'odaib',
        'password' => Hash::make('Welkom123!'),
    ]);

    $response = $this->post('/login', [
        'login' => 'odaib',
        'password' => 'Welkom123!',
    ]);

    $response
        ->assertRedirect('/')
        ->assertSessionHas('status_success', 'Succesvol ingelogd.');

    $this->assertAuthenticatedAs($user);
});

test('de gebruiker krijgt een foutmelding bij verkeerde inloggegevens', function () {
    User::factory()->create([
        'name' => 'testgebruiker',
        'password' => Hash::make('Correct123!'),
    ]);

    $response = $this->post('/login', [
        'login' => 'testgebruiker',
        'password' => 'FoutWachtwoord',
    ]);

    $response
        ->assertRedirect()
        ->assertSessionHas('status_error', 'Voer de juiste gegevens in.');

    $this->assertGuest();
});

test('de gebruiker kan uitloggen en ziet een succesmelding', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/logout');

    $response
        ->assertRedirect('/')
        ->assertSessionHas('status_success', 'Succesvol uitgelogd.');

    $this->assertGuest();
});

test('de gebruiker kan registreren en wordt direct ingelogd', function () {
    $response = $this->post('/register', [
        'name' => 'nieuwegebruiker',
        'email' => 'nieuw@example.com',
        'password' => 'Welkom123!',
        'password_confirmation' => 'Welkom123!',
    ]);

    $response
        ->assertRedirect('/')
        ->assertSessionHas('status_success', 'Account aangemaakt en succesvol ingelogd.');

    $this->assertAuthenticated();
    expect(auth()->user()->role)->toBe(User::ROLE_REISADVISEUR);
});

test('administrator kan accountoverzicht zien', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMINISTRATOR,
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/accounts');

    $response
        ->assertOk()
        ->assertSeeText('Accountoverzicht');
});

test('manager kan accountoverzicht zien', function () {
    $manager = User::factory()->create([
        'role' => User::ROLE_MANAGER,
    ]);

    $response = $this
        ->actingAs($manager)
        ->get('/accounts');

    $response
        ->assertOk()
        ->assertSeeText('Accountoverzicht');
});

test('reisadviseur kan accountoverzicht niet zien', function () {
    $advisor = User::factory()->create([
        'role' => User::ROLE_REISADVISEUR,
    ]);

    $this
        ->actingAs($advisor)
        ->get('/accounts')
        ->assertForbidden();
});

test('melding heeft auto-dismiss van vijf seconden', function () {
    $response = $this
        ->withSession(['status_success' => 'Succesvol ingelogd.'])
        ->get('/');

    $response->assertSee('data-auto-dismiss="5000"', false);
});

test('administrator wordt na inloggen doorgestuurd naar accountoverzicht', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMINISTRATOR,
        'password' => Hash::make('Welkom123!'),
    ]);

    $response = $this->post('/login', [
        'login' => $admin->email,
        'password' => 'Welkom123!',
    ]);

    $response
        ->assertRedirect('/accounts')
        ->assertSessionHas('status_success', 'Succesvol ingelogd.');
});

test('administrator kan dashboard beheren openen', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMINISTRATOR,
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/management/dashboard');

    $response
        ->assertOk()
        ->assertSeeText('Dashboard beheren')
        ->assertSeeText('Aantal Boeking Bekijken');
});

test('manager kan dashboard beheren openen', function () {
    $manager = User::factory()->create([
        'role' => User::ROLE_MANAGER,
    ]);

    $this
        ->actingAs($manager)
        ->get('/management/dashboard')
        ->assertOk()
        ->assertSeeText('Dashboard beheren')
        ->assertSeeText('Omzet bekijken');
});

test('financieel medewerker kan dashboard beheren openen', function () {
    $financialEmployee = User::factory()->create([
        'role' => User::ROLE_FINANCIEEL_MEDEWERKER,
    ]);

    $this
        ->actingAs($financialEmployee)
        ->get('/management/dashboard')
        ->assertOk()
        ->assertSeeText('Dashboard beheren')
        ->assertSeeText('Omzet bekijken');
});

test('administrator ziet melding als er geen boekingen beschikbaar zijn', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMINISTRATOR,
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/management/boekingen');

    $response
        ->assertOk()
        ->assertSeeText('Er zijn momenteel geen boekingen beschikbaar.');
});

test('administrator ziet boekingen in het managementoverzicht', function () {
    DB::table('reizen')->insert([
        'Id' => 1,
        'naam' => 'Testreis',
        'bestemming' => 'Nederland',
        'startdatum' => now()->toDateString(),
        'einddatum' => now()->addDays(3)->toDateString(),
        'prijs' => 100.00,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('boekingen')->insert([
        [
            'reisId' => 1,
            'aantal_personen' => 1,
            'datum_boeking' => now()->toDateTimeString(),
            'status' => 'geboekt',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'reisId' => 1,
            'aantal_personen' => 2,
            'datum_boeking' => now()->toDateTimeString(),
            'status' => 'bevestigd',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    $admin = User::factory()->create([
        'role' => User::ROLE_ADMINISTRATOR,
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/management/boekingen');

    $response
        ->assertOk()
        ->assertSeeText('Boekingen geladen')
        ->assertSeeText('Nederland')
        ->assertSeeText('Totaal boekingen: 2');
});

test('manager ziet omzet voor een geselecteerde periode', function () {
    DB::table('reizen')->insert([
        [
            'Id' => 1,
            'naam' => 'Testreis Nederland',
            'bestemming' => 'Nederland',
            'startdatum' => now()->toDateString(),
            'einddatum' => now()->addDays(3)->toDateString(),
            'prijs' => 500.00,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'Id' => 2,
            'naam' => 'Testreis Spanje',
            'bestemming' => 'Spanje',
            'startdatum' => now()->toDateString(),
            'einddatum' => now()->addDays(4)->toDateString(),
            'prijs' => 700.00,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    DB::table('boekingen')->insert([
        [
            'reisId' => 1,
            'aantal_personen' => 2,
            'datum_boeking' => now()->subDay()->toDateTimeString(),
            'status' => 'geboekt',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'reisId' => 2,
            'aantal_personen' => 1,
            'datum_boeking' => now()->toDateTimeString(),
            'status' => 'bevestigd',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'reisId' => 2,
            'aantal_personen' => 1,
            'datum_boeking' => now()->toDateTimeString(),
            'status' => 'geannuleerd',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    $manager = User::factory()->create([
        'role' => User::ROLE_MANAGER,
    ]);

    $response = $this
        ->actingAs($manager)
        ->get('/management/omzet?periode=aangepast&van_datum='.now()->subDays(2)->toDateString().'&tot_datum='.now()->toDateString());

    $response
        ->assertOk()
        ->assertSeeText('Omzet geladen')
        ->assertSeeText('Nederland')
        ->assertSeeText('Spanje')
        ->assertSeeText('Totale omzet in periode');
});

test('financieel medewerker ziet melding wanneer geen omzet beschikbaar is', function () {
    $financialEmployee = User::factory()->create([
        'role' => User::ROLE_FINANCIEEL_MEDEWERKER,
    ]);

    $response = $this
        ->actingAs($financialEmployee)
        ->get('/management/omzet?periode=aangepast&van_datum=2024-01-01&tot_datum=2024-01-31');

    $response
        ->assertOk()
        ->assertSeeText('Er is geen omzet beschikbaar voor de geselecteerde periode.');
});
