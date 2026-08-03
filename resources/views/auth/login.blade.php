<x-layouts.guest title="Log in — EcoLink">
    <h1 class="text-xl font-bold text-gray-900 mb-6">Log in to your account</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="remember" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
            Remember me
        </label>

        <x-primary-button class="w-full justify-center">Log in</x-primary-button>
    </form>

    <p class="mt-6 text-sm text-center text-gray-600">
        Don't have an account? <a href="{{ route('register') }}" class="text-green-600 font-medium hover:underline">Register</a>
    </p>
</x-layouts.guest>
