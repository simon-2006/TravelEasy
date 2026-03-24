<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role', 'created_at']);

        return view('accounts.index', [
            'users' => $users,
        ]);
    }

    public function create(): View
    {
        return view('accounts.create', [
            'roles' => User::ROLES,
        ]);
    }

    public function store(StoreAccountRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()
            ->route('accounts.index')
            ->with('status_success', 'Het nieuwe account is succesvol toegevoegd.');
    }
}
