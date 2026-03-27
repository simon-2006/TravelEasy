<?php

namespace App\Http\Controllers;

use App\Models\Boeking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ManagementDashboardController extends Controller
{
    public function index(): View
    {
        return view('management.index');
    }

    public function bookings(Request $request): View
    {
        $bookings = Boeking::overzichtRijen();
        $totalBookings = Boeking::totaalAantal();

        if ($bookings->isEmpty()) {
            $request->session()->flash('status_error', 'Er zijn momenteel geen boekingen beschikbaar.');
        } else {
            $request->session()->flash('status_success', "Boekingen geladen: {$totalBookings} totaal.");
        }

        return view('management.bookings', [
            'bookings' => $bookings,
            'totalBookings' => $totalBookings,
        ]);
    }

    public function facturen(): View
    {
        $facturen = DB::table('facturen')->get();
        return view('management.facturen', compact('facturen'));
    }
}
