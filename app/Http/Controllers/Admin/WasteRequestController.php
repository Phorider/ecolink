<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WasteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WasteRequestController extends Controller
{
    /**
     * Display a listing of all waste requests, with search by type and status filter.
     */
    public function index(Request $request): View
    {
        $requests = WasteRequest::query()
            ->with(['citizen', 'collector'])
            ->ofType($request->query('type'))
            ->when($request->query('status'), fn ($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.requests.index', [
            'requests' => $requests,
            'types' => WasteRequest::TYPES,
            'statuses' => WasteRequest::STATUSES,
        ]);
    }

    /**
     * Show a single waste request.
     */
    public function show(WasteRequest $wasteRequest): View
    {
        $wasteRequest->load(['citizen', 'collector']);

        return view('admin.requests.show', compact('wasteRequest'));
    }

    /**
     * Delete an inappropriate waste request.
     */
    public function destroy(WasteRequest $wasteRequest): RedirectResponse
    {
        $wasteRequest->delete();

        return redirect()->route('admin.requests.index')
            ->with('status', 'Request deleted successfully.');
    }
}
