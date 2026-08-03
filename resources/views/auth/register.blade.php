<x-layouts.guest title="Register — EcoLink">
    <h1 class="text-xl font-bold text-gray-900 mb-6">Create your account</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Full Name" />
            <x-text-input id="name" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="phone" value="Phone (optional)" />
            <x-text-input id="phone" name="phone" :value="old('phone')" />
            <x-input-error :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label value="I am a..." />
            <div class="grid grid-cols-2 gap-3">
                <label class="flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-2 cursor-pointer has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                    <input type="radio" name="role" value="citizen" class="text-green-600 focus:ring-green-500" {{ old('role', 'citizen') === 'citizen' ? 'checked' : '' }}>
                    <span class="text-sm">Citizen</span>
                </label>
                <label class="flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-2 cursor-pointer has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                    <input type="radio" name="role" value="collector" class="text-green-600 focus:ring-green-500" {{ old('role') === 'collector' ? 'checked' : '' }}>
                    <span class="text-sm">Collector</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required />
        </div>

        <x-primary-button class="w-full justify-center">Register</x-primary-button>
    </form>

    <p class="mt-6 text-sm text-center text-gray-600">
        Already have an account? <a href="{{ route('login') }}" class="text-green-600 font-medium hover:underline">Log in</a>
    </p>
</x-layouts.guest>
