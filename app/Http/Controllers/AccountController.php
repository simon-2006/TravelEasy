<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}
