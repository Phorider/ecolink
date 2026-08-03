<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\WasteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WasteRequestController extends Controller
{
    /**
     * Display a listing of the citizen's waste requests.
     */
    public function index(Request $request): View
    {
        $requests = $request->user()
            ->wasteRequests()
            ->ofType($request->query('type'))
            ->when($request->query('status'), fn ($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('citizen.requests.index', [
            'requests' => $requests,
            'types' => WasteRequest::TYPES,
            'statuses' => WasteRequest::STATUSES,
        ]);
    }

    /**
     * Show the form for creating a new waste request.
     */
    public function create(): View
    {
        return view('citizen.requests.create', [
            'types' => WasteRequest::TYPES,
        ]);
    }

    /**
     * Store a newly created waste request.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:'.implode(',', WasteRequest::TYPES)],
            'weight' => ['required', 'numeric', 'min:0.1', 'max:99999'],
            'address' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('waste_images', 'public');
        }

        $request->user()->wasteRequests()->create($validated);

        return redirect()->route('citizen.requests.index')
            ->with('status', 'Your waste request has been submitted.');
    }

    /**
     * Display the specified waste request.
     */
    public function show(Request $request, WasteRequest $wasteRequest): View
    {
        $this->authorizeOwner($request, $wasteRequest);

        return view('citizen.requests.show', compact('wasteRequest'));
    }

    /**
     * Cancel the specified waste request (only if still Pending).
     */
    public function destroy(Request $request, WasteRequest $wasteRequest): RedirectResponse
    {
        $this->authorizeOwner($request, $wasteRequest);

        if ($wasteRequest->status !== 'Pending') {
            return back()->with('error', 'Only pending requests can be cancelled.');
        }

        $wasteRequest->update(['status' => 'Cancelled']);

        return redirect()->route('citizen.requests.index')
            ->with('status', 'Request cancelled successfully.');
    }

    protected function authorizeOwner(Request $request, WasteRequest $wasteRequest): void
    {
        abort_unless($wasteRequest->user_id === $request->user()->id, 403);
    }
}
