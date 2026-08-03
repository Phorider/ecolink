<x-layouts.app title="My Requests — EcoLink">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">My Waste Requests</h1>
        <a href="{{ route('citizen.requests.create') }}" class="text-sm font-medium bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">+ New Request</a>
    </div>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <select name="type" class="rounded-lg border-gray-300 text-sm focus:border-green-500 focus:ring-green-500">
            <option value="">All types</option>
            @foreach ($types as $type)
                <option value="{{ $type }}" @selected(request('type') === $type)>{{ $type }}</option>
            @endforeach
        </select>
        <select name="status" class="rounded-lg border-gray-300 text-sm focus:border-green-500 focus:ring-green-500">
            <option value="">All statuses</option>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
            @endforeach
        </select>
        <button class="text-sm font-medium bg-gray-100 px-4 py-2 rounded-lg hover:bg-gray-200">Filter</button>
        @if (request('type') || request('status'))
            <a href="{{ route('citizen.requests.index') }}" class="text-sm font-medium text-gray-500 px-4 py-2 hover:underline">Clear</a>
        @endif
    </form>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100">
        @forelse ($requests as $req)
            <div class="flex items-center justify-between px-5 py-4">
                <a href="{{ route('citizen.requests.show', $req) }}" class="flex-1">
                    <p class="font-medium text-gray-900">{{ $req->type }} · {{ $req->weight }} kg</p>
                    <p class="text-sm text-gray-500">{{ $req->address }}</p>
                    <p class="text-xs text-gray-400 mt-1">Submitted {{ $req->created_at->diffForHumans() }}</p>
                </a>
                <div class="flex items-center gap-3">
                    <x-badge :color="$req->statusBadgeColor()">{{ $req->status }}</x-badge>
                    @if ($req->status === 'Pending')
                        <form method="POST" action="{{ route('citizen.requests.destroy', $req) }}" onsubmit="return confirm('Cancel this request?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-sm font-medium text-red-600 hover:underline">Cancel</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="px-5 py-6 text-sm text-gray-500">No requests found.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $requests->links() }}
    </div>
</x-layouts.app>
