<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use App\Models\WasteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RequestController extends Controller
{
    /**
     * Show all available (Pending) requests for collectors to pick up.
     */
    public function available(Request $request): View
    {
        $requests = WasteRequest::with('citizen')
            ->pending()
            ->ofType($request->query('type'))
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('collector.available', [
            'requests' => $requests,
            'types' => WasteRequest::TYPES,
        ]);
    }

    /**
     * Accept a pending request.
     */
    public function accept(Request $request, WasteRequest $wasteRequest): RedirectResponse
    {
        if ($wasteRequest->status !== 'Pending') {
            return back()->with('error', 'This request has already been taken.');
        }

        $wasteRequest->update([
            'collector_id' => $request->user()->id,
            'status' => 'Accepted',
            'accepted_at' => now(),
        ]);

        return redirect()->route('collector.jobs')
            ->with('status', 'Request accepted. It now appears in your active jobs.');
    }

    /**
     * List the collector's active (Accepted) jobs.
     */
    public function jobs(Request $request): View
    {
        $requests = $request->user()
            ->collectedRequests()
            ->with('citizen')
            ->where('status', 'Accepted')
            ->latest()
            ->paginate(8);

        return view('collector.jobs', compact('requests'));
    }

    /**
     * Mark an accepted job as Collected.
     */
    public function markCollected(Request $request, WasteRequest $wasteRequest): RedirectResponse
    {
        abort_unless($wasteRequest->collector_id === $request->user()->id, 403);

        if ($wasteRequest->status !== 'Accepted') {
            return back()->with('error', 'Only accepted jobs can be marked as collected.');
        }

        $wasteRequest->update([
            'status' => 'Collected',
            'collected_at' => now(),
        ]);

        return back()->with('status', 'Job marked as collected. Great work!');
    }

    /**
     * List the collector's completed jobs.
     */
    public function completed(Request $request): View
    {
        $requests = $request->user()
            ->collectedRequests()
            ->with('citizen')
            ->where('status', 'Collected')
            ->latest()
            ->paginate(8);

        return view('collector.completed', compact('requests'));
    }
}
