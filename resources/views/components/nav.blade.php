<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-bold text-xl text-green-700">
                    <span>🌱</span> EcoLink
                </a>

                @auth
                    <div class="hidden sm:flex gap-6 text-sm font-medium text-gray-600">
                        @if (auth()->user()->isCitizen())
                            <a href="{{ route('citizen.requests.index') }}" class="hover:text-green-700 {{ request()->routeIs('citizen.requests.*') ? 'text-green-700' : '' }}">My Requests</a>
                            <a href="{{ route('citizen.requests.create') }}" class="hover:text-green-700 {{ request()->routeIs('citizen.requests.create') ? 'text-green-700' : '' }}">New Request</a>
                        @elseif (auth()->user()->isCollector())
                            <a href="{{ route('collector.available') }}" class="hover:text-green-700 {{ request()->routeIs('collector.available') ? 'text-green-700' : '' }}">Available Requests</a>
                            <a href="{{ route('collector.jobs') }}" class="hover:text-green-700 {{ request()->routeIs('collector.jobs') ? 'text-green-700' : '' }}">My Jobs</a>
                            <a href="{{ route('collector.completed') }}" class="hover:text-green-700 {{ request()->routeIs('collector.completed') ? 'text-green-700' : '' }}">Completed</a>
                        @elseif (auth()->user()->isAdmin())
                            <a href="{{ route('admin.users.index') }}" class="hover:text-green-700 {{ request()->routeIs('admin.users.*') ? 'text-green-700' : '' }}">Users</a>
                            <a href="{{ route('admin.requests.index') }}" class="hover:text-green-700 {{ request()->routeIs('admin.requests.*') ? 'text-green-700' : '' }}">Requests</a>
                        @endif
                    </div>
                @endauth
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <span class="text-sm text-gray-500 hidden sm:inline">{{ auth()->user()->name }} <span class="text-xs uppercase text-green-600 font-semibold">({{ auth()->user()->role }})</span></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-gray-600 hover:text-red-600">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-green-700">Log in</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
