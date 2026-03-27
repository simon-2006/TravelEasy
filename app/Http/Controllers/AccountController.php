<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class AccountController extends Controller
{
    public function index(): View
    {
        $users = Account::overzichtLijst();

        return view('accounts.index', [
            'users' => $users,
            'roles' => User::ROLES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', Rule::in(User::ROLES)],
            'functie' => ['required', 'string', 'max:120'],
            'telefoon' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            // Onderdeel voor je opdracht: account aanmaken + INNER JOIN verificatie via model.
            $nieuwAccount = Account::voegToeMetMedewerker($attributes);

            // Technische log (succes): handig om in storage/logs te tonen aan je docent.
            Log::info('Technische log: nieuw account toegevoegd.', [
                'account_id' => $nieuwAccount->id,
                'email' => $nieuwAccount->email,
                'functie' => $nieuwAccount->functie,
                'aangemaakt_door' => $request->user()?->id,
            ]);
        } catch (Throwable $exception) {
            // Technische log (fout): hierdoor kun je aantonen dat fouten netjes worden afgehandeld.
            Log::error('Technische log: nieuw account toevoegen mislukt.', [
                'error_class' => $exception::class,
                'error_message' => $exception->getMessage(),
                'email_payload' => $request->input('email'),
                'aangemaakt_door' => $request->user()?->id,
            ]);

            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->with('status_error', 'Nieuw account aanmaken is mislukt. Controleer de technische log.');
        }

        return redirect()
            ->route('accounts.index')
            ->with('status_success', "Nieuw account '{$nieuwAccount->name}' is toegevoegd.");
    }
}
