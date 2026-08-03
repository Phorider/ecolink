<x-layouts.app title="Available Requests — EcoLink">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Available Requests</h1>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <select name="type" class="rounded-lg border-gray-300 text-sm focus:border-green-500 focus:ring-green-500">
            <option value="">All types</option>
            @foreach ($types as $type)
                <option value="{{ $type }}" @selected(request('type') === $type)>{{ $type }}</option>
            @endforeach
        </select>
        <button class="text-sm font-medium bg-gray-100 px-4 py-2 rounded-lg hover:bg-gray-200">Filter</button>
        @if (request('type'))
            <a href="{{ route('collector.available') }}" class="text-sm font-medium text-gray-500 px-4 py-2 hover:underline">Clear</a>
        @endif
    </form>

    <div class="grid sm:grid-cols-2 gap-4">
        @forelse ($requests as $req)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="font-semibold text-gray-900">{{ $req->type }} · {{ $req->weight }} kg</p>
                    <x-badge :color="$req->statusBadgeColor()">{{ $req->status }}</x-badge>
                </div>
                <p class="text-sm text-gray-600 mb-1">{{ $req->address }}</p>
                @if ($req->description)
                    <p class="text-sm text-gray-500 mb-3">{{ Str::limit($req->description, 100) }}</p>
                @endif
                <p class="text-xs text-gray-400 mb-4">Posted by {{ $req->citizen->name }} · {{ $req->created_at->diffForHumans() }}</p>
                <form method="POST" action="{{ route('collector.accept', $req) }}">
                    @csrf
                    <button class="w-full text-sm font-medium bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Accept Request</button>
                </form>
            </div>
        @empty
            <p class="text-sm text-gray-500 sm:col-span-2">No available requests right now. Check back soon.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $requests->links() }}
    </div>
</x-layouts.app>
