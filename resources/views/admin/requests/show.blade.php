<x-layouts.app title="Request Details — EcoLink">
    <a href="{{ route('admin.requests.index') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; Back to all requests</a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-4 max-w-2xl">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h1 class="text-xl font-bold text-gray-900">{{ $wasteRequest->type }} · {{ $wasteRequest->weight }} kg</h1>
                <p class="text-sm text-gray-500">Submitted {{ $wasteRequest->created_at->format('M d, Y H:i') }}</p>
            </div>
            <x-badge :color="$wasteRequest->statusBadgeColor()">{{ $wasteRequest->status }}</x-badge>
        </div>

        @if ($wasteRequest->image)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($wasteRequest->image) }}" alt="Waste photo" class="rounded-lg mb-4 max-h-72 object-cover w-full">
        @endif

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mb-4">
            <div>
                <dt class="text-gray-500">Citizen</dt>
                <dd class="text-gray-900 font-medium">{{ $wasteRequest->citizen->name }} ({{ $wasteRequest->citizen->email }})</dd>
            </div>
            <div>
                <dt class="text-gray-500">Collector</dt>
                <dd class="text-gray-900 font-medium">{{ $wasteRequest->collector->name ?? 'Unassigned' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Address</dt>
                <dd class="text-gray-900 font-medium">{{ $wasteRequest->address }}</dd>
            </div>
        </dl>

        @if ($wasteRequest->description)
            <div class="mb-6">
                <dt class="text-gray-500 text-sm mb-1">Description</dt>
                <dd class="text-gray-800 text-sm">{{ $wasteRequest->description }}</dd>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.requests.destroy', $wasteRequest) }}" onsubmit="return confirm('Delete this request permanently?')">
            @csrf
            @method('DELETE')
            <button class="text-sm font-medium bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Delete Request</button>
        </form>
    </div>
</x-layouts.app>
