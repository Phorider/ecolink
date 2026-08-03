<x-layouts.app title="Manage Requests — EcoLink">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Manage Waste Requests</h1>

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
            <a href="{{ route('admin.requests.index') }}" class="text-sm font-medium text-gray-500 px-4 py-2 hover:underline">Clear</a>
        @endif
    </form>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-5 py-3 font-medium">Type</th>
                    <th class="px-5 py-3 font-medium">Citizen</th>
                    <th class="px-5 py-3 font-medium">Collector</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Created</th>
                    <th class="px-5 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($requests as $req)
                    <tr>
                        <td class="px-5 py-3 text-gray-900 font-medium">{{ $req->type }} ({{ $req->weight }}kg)</td>
                        <td class="px-5 py-3 text-gray-600">{{ $req->citizen->name }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $req->collector->name ?? '—' }}</td>
                        <td class="px-5 py-3"><x-badge :color="$req->statusBadgeColor()">{{ $req->status }}</x-badge></td>
                        <td class="px-5 py-3 text-gray-500">{{ $req->created_at->format('M d, Y') }}</td>
                        <td class="px-5 py-3 text-right space-x-3">
                            <a href="{{ route('admin.requests.show', $req) }}" class="text-green-600 hover:underline font-medium">View</a>
                            <form method="POST" action="{{ route('admin.requests.destroy', $req) }}" class="inline" onsubmit="return confirm('Delete this request?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-6 text-center text-gray-500">No requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $requests->links() }}
    </div>
</x-layouts.app>
