<x-layouts.app title="Completed Jobs — EcoLink">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Completed Jobs</h1>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100">
        @forelse ($requests as $req)
            <div class="flex items-center justify-between px-5 py-4">
                <div>
                    <p class="font-medium text-gray-900">{{ $req->type }} · {{ $req->weight }} kg</p>
                    <p class="text-sm text-gray-500">{{ $req->address }}</p>
                    <p class="text-xs text-gray-400 mt-1">Citizen: {{ $req->citizen->name }} · Collected {{ $req->collected_at?->diffForHumans() }}</p>
                </div>
                <x-badge :color="$req->statusBadgeColor()">{{ $req->status }}</x-badge>
            </div>
        @empty
            <p class="px-5 py-6 text-sm text-gray-500">No completed jobs yet.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $requests->links() }}
    </div>
</x-layouts.app>
