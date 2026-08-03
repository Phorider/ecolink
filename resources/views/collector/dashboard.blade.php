<x-layouts.app title="Dashboard — EcoLink">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Welcome back, {{ auth()->user()->name }}</h1>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">Available Requests</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['available'] }}</p>
            <a href="{{ route('collector.available') }}" class="text-xs text-green-600 hover:underline">Browse now &rarr;</a>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">In Progress</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['in_progress'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">Completed</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
        </div>
    </div>

    <h2 class="text-lg font-semibold text-gray-900 mb-4">Active Jobs</h2>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100">
        @forelse ($acceptedJobs as $job)
            <div class="flex items-center justify-between px-5 py-4">
                <div>
                    <p class="font-medium text-gray-900">{{ $job->type }} · {{ $job->weight }} kg</p>
                    <p class="text-sm text-gray-500">{{ $job->address }}</p>
                </div>
                <form method="POST" action="{{ route('collector.collect', $job) }}">
                    @csrf
                    <button class="text-sm font-medium bg-green-600 text-white px-3 py-1.5 rounded-lg hover:bg-green-700">Mark Collected</button>
                </form>
            </div>
        @empty
            <p class="px-5 py-6 text-sm text-gray-500">No active jobs. <a href="{{ route('collector.available') }}" class="text-green-600 hover:underline">Browse available requests</a>.</p>
        @endforelse
    </div>
</x-layouts.app>
