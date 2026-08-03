<x-layouts.app title="New Request — EcoLink">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">New Waste Request</h1>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">
        <form method="POST" action="{{ route('citizen.requests.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="type" value="Waste Type" />
                <select id="type" name="type" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                    <option value="">Select a type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" @selected(old('type') === $type)>{{ $type }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type')" />
            </div>

            <div>
                <x-input-label for="weight" value="Estimated Weight (kg)" />
                <x-text-input id="weight" type="number" step="0.1" min="0.1" name="weight" :value="old('weight')" required />
                <x-input-error :messages="$errors->get('weight')" />
            </div>

            <div>
                <x-input-label for="address" value="Pickup Address" />
                <x-text-input id="address" name="address" :value="old('address')" required />
                <x-input-error :messages="$errors->get('address')" />
            </div>

            <div>
                <x-input-label for="description" value="Description (optional)" />
                <textarea id="description" name="description" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" />
            </div>

            <div>
                <x-input-label for="image" value="Photo (optional)" />
                <input id="image" type="file" name="image" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                <x-input-error :messages="$errors->get('image')" />
            </div>

            <div class="flex gap-3">
                <x-primary-button>Submit Request</x-primary-button>
                <a href="{{ route('citizen.requests.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>
