{{-- layouts/sidebar.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white flex flex-col">
            <div class="h-16 flex items-center justify-center font-bold text-xl border-b border-blue-700">
                Aplikasi Pengelolaan Barang
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('barang-masuk.index') }}" class="block py-2 px-4 rounded hover:bg-blue-700 {{ request()->is('barang-masuk*') ? 'bg-blue-800' : '' }}">
                    Barang Masuk
                </a>
                <a href="{{ route('kategori.index') }}" class="block py-2 px-4 rounded hover:bg-blue-700 {{ request()->is('kategori*') ? 'bg-blue-800' : '' }}">
                    Master Data
                </a>
                <a href="{{ route('users.index') }}" class="block py-2 px-4 rounded hover:bg-blue-700 {{ request()->is('users*') ? 'bg-blue-800' : '' }}">
                    Manajemen User
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar -->
            <header class="h-16 bg-white shadow flex items-center justify-end px-6">
                <div class="relative">
                    <button class="flex items-center space-x-2 text-sm focus:outline-none">
                        <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center">
                            {{ strtoupper(auth()->user()->name[0]) }}
                        </div>
                        <div class="text-left">
                            <div class="font-bold">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-gray-500 capitalize">{{ auth()->user()->getRoleNames()->first() }}</div>
                        </div>
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="absolute right-0 mt-2 text-red-600 text-sm hover:underline">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
