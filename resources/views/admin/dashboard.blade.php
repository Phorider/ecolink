<x-layouts.app title="Admin Dashboard — EcoLink">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500">Users</p>
            <p class="text-xl font-bold text-gray-900">{{ $stats['users'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500">Citizens</p>
            <p class="text-xl font-bold text-gray-900">{{ $stats['citizens'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500">Collectors</p>
            <p class="text-xl font-bold text-gray-900">{{ $stats['collectors'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500">Requests</p>
            <p class="text-xl font-bold text-gray-900">{{ $stats['requests'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500">Pending</p>
            <p class="text-xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500">Collected</p>
            <p class="text-xl font-bold text-green-600">{{ $stats['collected'] }}</p>
        </div>
    </div>

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900">Recent Requests</h2>
        <a href="{{ route('admin.requests.index') }}" class="text-sm text-green-600 hover:underline">View all &rarr;</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100">
        @forelse ($recentRequests as $req)
            <div class="flex items-center justify-between px-5 py-4">
                <div>
                    <p class="font-medium text-gray-900">{{ $req->type }} · {{ $req->weight }} kg</p>
                    <p class="text-sm text-gray-500">{{ $req->citizen->name }} → {{ $req->collector->name ?? 'Unassigned' }}</p>
                </div>
                <x-badge :color="$req->statusBadgeColor()">{{ $req->status }}</x-badge>
            </div>
        @empty
            <p class="px-5 py-6 text-sm text-gray-500">No requests yet.</p>
        @endforelse
    </div>
</x-layouts.app>
