<x-layouts.app title="Manage Users — EcoLink">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Manage Users</h1>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" placeholder="Search name or email" value="{{ request('search') }}" class="rounded-lg border-gray-300 text-sm focus:border-green-500 focus:ring-green-500 w-64">
        <select name="role" class="rounded-lg border-gray-300 text-sm focus:border-green-500 focus:ring-green-500">
            <option value="">All roles</option>
            <option value="citizen" @selected(request('role') === 'citizen')>Citizen</option>
            <option value="collector" @selected(request('role') === 'collector')>Collector</option>
            <option value="admin" @selected(request('role') === 'admin')>Admin</option>
        </select>
        <button class="text-sm font-medium bg-gray-100 px-4 py-2 rounded-lg hover:bg-gray-200">Filter</button>
        @if (request('search') || request('role'))
            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-gray-500 px-4 py-2 hover:underline">Clear</a>
        @endif
    </form>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-5 py-3 font-medium">Name</th>
                    <th class="px-5 py-3 font-medium">Email</th>
                    <th class="px-5 py-3 font-medium">Role</th>
                    <th class="px-5 py-3 font-medium">Joined</th>
                    <th class="px-5 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($users as $user)
                    <tr>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $user->email }}</td>
                        <td class="px-5 py-3"><span class="uppercase text-xs font-semibold text-green-700">{{ $user->role }}</span></td>
                        <td class="px-5 py-3 text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-5 py-3 text-right">
                            @if ($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline font-medium">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-6 text-center text-gray-500">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</x-layouts.app>
