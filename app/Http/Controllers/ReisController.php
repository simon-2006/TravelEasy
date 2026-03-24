<?php

namespace App\Http\Controllers;

use App\Models\Reis;

class ReisController extends Controller
{
    public function index()
    {
        $reizen = Reis::orderBy('id', 'desc')->get();
        return view('reizen.index', compact('reizen'));
    }

    public function show($id)
    {
        $reis = Reis::find($id);

        if (!$reis) {
            return redirect()->route('reizen.index')
                ->with('error', 'Reis niet gevonden');
        }

        return view('reizen.show', compact('reis'));
    }
}
