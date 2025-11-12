<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - CampusMarket</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold text-blue-600">🛒 CampusMarket</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-gray-700">{{ auth()->user()->name }}</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Seller</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-red-600 hover:text-red-800">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <h2 class="text-3xl font-bold text-gray-900 mb-6">Seller Dashboard</h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Total Products</h3>
                    <p class="text-3xl font-bold text-blue-600">0</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Orders</h3>
                    <p class="text-3xl font-bold text-purple-600">0</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Revenue</h3>
                    <p class="text-3xl font-bold text-green-600">Rp 0</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Reviews</h3>
                    <p class="text-3xl font-bold text-yellow-600">0</p>
                </div>
            </div>

            <div class="mt-8 bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-bold mb-4">Store Information</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Store Name:</p>
                        <p class="font-semibold">{{ auth()->user()->store_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">PIC Name:</p>
                        <p class="font-semibold">{{ auth()->user()->pic_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Email Verified:</p>
                        <p class="font-semibold text-green-600">✅
                            {{ auth()->user()->email_verified_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
