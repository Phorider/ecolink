<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WasteRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the appropriate dashboard based on the authenticated user's role.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        return match ($user->role) {
            'citizen' => $this->citizenDashboard($user),
            'collector' => $this->collectorDashboard($user),
            'admin' => $this->adminDashboard(),
            default => abort(403),
        };
    }

    protected function citizenDashboard(User $user): View
    {
        $requests = $user->wasteRequests()->latest()->take(5)->get();

        $stats = [
            'total' => $user->wasteRequests()->count(),
            'pending' => $user->wasteRequests()->where('status', 'Pending')->count(),
            'accepted' => $user->wasteRequests()->where('status', 'Accepted')->count(),
            'collected' => $user->wasteRequests()->where('status', 'Collected')->count(),
        ];

        return view('citizen.dashboard', compact('requests', 'stats'));
    }

    protected function collectorDashboard(User $user): View
    {
        $availableCount = WasteRequest::where('status', 'Pending')->count();
        $acceptedJobs = $user->collectedRequests()->where('status', 'Accepted')->latest()->take(5)->get();

        $stats = [
            'available' => $availableCount,
            'in_progress' => $user->collectedRequests()->where('status', 'Accepted')->count(),
            'completed' => $user->collectedRequests()->where('status', 'Collected')->count(),
        ];

        return view('collector.dashboard', compact('acceptedJobs', 'stats'));
    }

    protected function adminDashboard(): View
    {
        $stats = [
            'users' => User::count(),
            'citizens' => User::where('role', 'citizen')->count(),
            'collectors' => User::where('role', 'collector')->count(),
            'requests' => WasteRequest::count(),
            'pending' => WasteRequest::where('status', 'Pending')->count(),
            'collected' => WasteRequest::where('status', 'Collected')->count(),
        ];

        $recentRequests = WasteRequest::with(['citizen', 'collector'])->latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'recentRequests'));
    }
}
