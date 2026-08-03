<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EcoLink — Recycling made simple</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <x-nav />

    <section class="max-w-5xl mx-auto px-6 py-20 text-center">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-4">
            Connect your recyclables with <span class="text-green-600">nearby collectors</span>
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
            EcoLink makes it simple for citizens to request pickup of plastic, paper, glass, metal,
            e-waste, and organic waste — and for collectors to find and complete jobs nearby.
        </p>
        <div class="flex justify-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700">Go to Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700">Get Started</a>
                <a href="{{ route('login') }}" class="bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-100">Log In</a>
            @endauth
        </div>

        <div class="grid sm:grid-cols-3 gap-6 mt-16 text-left">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="text-3xl mb-2">♻️</div>
                <h3 class="font-semibold text-gray-900 mb-1">Citizens</h3>
                <p class="text-sm text-gray-600">Submit a waste pickup request in seconds with type, weight, and location.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="text-3xl mb-2">🚛</div>
                <h3 class="font-semibold text-gray-900 mb-1">Collectors</h3>
                <p class="text-sm text-gray-600">Browse available requests, accept jobs, and mark them collected.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="text-3xl mb-2">🛡️</div>
                <h3 class="font-semibold text-gray-900 mb-1">Admins</h3>
                <p class="text-sm text-gray-600">Oversee users and requests, and remove inappropriate content.</p>
            </div>
        </div>
    </section>
</body>
</html>
