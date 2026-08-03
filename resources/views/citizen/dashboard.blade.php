<x-layouts.app title="Dashboard — EcoLink">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Welcome back, {{ auth()->user()->name }}</h1>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">Total Requests</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">Accepted</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['accepted'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">Collected</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['collected'] }}</p>
        </div>
    </div>

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900">Recent Requests</h2>
        <a href="{{ route('citizen.requests.create') }}" class="text-sm font-medium bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">+ New Request</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100">
        @forelse ($requests as $req)
            <a href="{{ route('citizen.requests.show', $req) }}" class="flex items-center justify-between px-5 py-4 hover:bg-gray-50">
                <div>
                    <p class="font-medium text-gray-900">{{ $req->type }} · {{ $req->weight }} kg</p>
                    <p class="text-sm text-gray-500">{{ $req->address }}</p>
                </div>
                <x-badge :color="$req->statusBadgeColor()">{{ $req->status }}</x-badge>
            </a>
        @empty
            <p class="px-5 py-6 text-sm text-gray-500">You haven't created any requests yet.</p>
        @endforelse
    </div>
</x-layouts.app>
