<?php

namespace App\Http\Controllers;

use App\Http\Requests\ViewRevenueRequest;
use App\Models\Boeking;
use App\Models\Omzet;
use Illuminate\Http\Request;
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

    public function revenue(ViewRevenueRequest $request): View
    {
        $period = $request->periodRange();
        $revenues = Omzet::overzichtVoorPeriode($period['from'], $period['to']);
        $totalRevenue = Omzet::totaalVoorOverzicht($revenues);

        if ($request->hasSubmittedFilter()) {
            if ($revenues->isEmpty()) {
                $request->session()->flash('status_error', 'Er is geen omzet beschikbaar voor de geselecteerde periode.');
            } else {
                $request->session()->flash(
                    'status_success',
                    "Omzet geladen voor {$period['label']} ({$period['from']->format('d-m-Y')} t/m {$period['to']->format('d-m-Y')})."
                );
            }
        }

        return view('management.revenue', [
            'revenues' => $revenues,
            'totalRevenue' => $totalRevenue,
            'selectedPeriod' => $period['periode'],
            'periodLabel' => $period['label'],
            'startDate' => $period['from']->toDateString(),
            'endDate' => $period['to']->toDateString(),
        ]);
    }
}
