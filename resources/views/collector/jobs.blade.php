<x-layouts.app title="My Jobs — EcoLink">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">My Active Jobs</h1>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100">
        @forelse ($requests as $req)
            <div class="flex items-center justify-between px-5 py-4">
                <div>
                    <p class="font-medium text-gray-900">{{ $req->type }} · {{ $req->weight }} kg</p>
                    <p class="text-sm text-gray-500">{{ $req->address }}</p>
                    <p class="text-xs text-gray-400 mt-1">Citizen: {{ $req->citizen->name }} · Accepted {{ $req->accepted_at?->diffForHumans() }}</p>
                </div>
                <form method="POST" action="{{ route('collector.collect', $req) }}">
                    @csrf
                    <button class="text-sm font-medium bg-green-600 text-white px-3 py-1.5 rounded-lg hover:bg-green-700">Mark Collected</button>
                </form>
            </div>
        @empty
            <p class="px-5 py-6 text-sm text-gray-500">You have no active jobs. <a href="{{ route('collector.available') }}" class="text-green-600 hover:underline">Browse available requests</a>.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $requests->links() }}
    </div>
</x-layouts.app>
