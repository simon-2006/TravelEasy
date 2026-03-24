<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reis;

class ReisController extends Controller
{
    public function index()
    {
        $reizen = Reis::all();
        return view('reizen.index', compact('reizen'));
    }

    public function show($id)
    {
        $reis = Reis::find($id);

        if (!$reis) {
            return redirect()->route('reizen.index')
                ->with('error', 'Reis niet gevonden');
        }

    }
}
