<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon_io/favicon.ico') }}" type="image/x-icon">
    <title>@yield('title', 'SMK PGRI 2 PALEMBANG')</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white p-5 hidden md:block min-h-screen h-screen sticky top-0 left-0 overflow-y-auto">
        <div class="flex items-center justify-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20">
        </div>
        <nav>
            <ul>
                <li class="py-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 bg-gray-800 rounded">
                        <i data-lucide="home"></i> Dashboard
                    </a>
                </li>

                @if(Auth::user()->role === 'Admin')
                <!-- Dropdown Data Master -->
                <li class="py-2">
                    <button id="data-master-toggle" class="flex items-center justify-between px-4 py-2 w-full text-left hover:bg-gray-800 rounded">
                        <span class="flex items-center gap-3">
                            <i data-lucide="database"></i> Data Master
                        </span>
                        <i id="dropdown-icon" data-lucide="chevron-down"></i>
                    </button>
                    <ul id="data-master-menu" class="hidden pl-6 mt-2 space-y-2">
                        <li><a href="{{ route('admin.students') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded"><i data-lucide="user"></i> Siswa</a></li>
                        <li><a href="{{ route('admin.teachers') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded"><i data-lucide="users"></i> Guru Pembimbing</a></li>
                        <li><a href="{{ route('admin.mentors') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded"><i data-lucide="users"></i> Pembimbing Industri</a></li>
                        <li><a href="{{ route('admin.humass') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded"><i data-lucide="users"></i> Admin Humas</a></li>
                        <li><a href="{{ route('admin.industries') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded"><i data-lucide="building"></i> Tempat Industri</a></li>
                        <li><a href="{{ route('admin.pkls') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded"><i data-lucide="briefcase"></i> PKL</a></li>
                    </ul>
                </li>
                @endif

                <li class="py-2">
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-800 rounded">
                        <i data-lucide="user"></i> Profil
                    </a>
                </li>

                <li class="py-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 px-4 py-2 w-full text-left hover:bg-red-600 rounded">
                            <i data-lucide="log-out"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-md p-4 flex justify-between items-center">
            <button id="menu-toggle" class="md:hidden">
                <i data-lucide="menu"></i>
            </button>
            <h1 class="text-xl font-semibold">@yield('title', 'SMK PGRI 2 PALEMBANG')</h1>
            <div class="flex items-center gap-4">
                <span class="text-gray-700">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6">
            @if (session('success'))
            <div class="p-3 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 rounded">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="p-3 mb-4 text-red-700 bg-red-100 border-l-4 border-red-500 rounded">
                {{ session('error') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="p-3 mb-4 text-red-700 bg-red-100 border-l-4 border-red-500 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @yield('content')

        </main>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <aside class="w-64 bg-gray-900 text-white p-5 absolute left-0 top-0 h-full">
            <button id="close-sidebar" class="absolute top-4 right-4 text-white">
                <i data-lucide="x"></i>
            </button>
            <nav>
                <ul>
                    <li class="py-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 bg-gray-800 rounded">
                            <i data-lucide="home"></i> Dashboard
                        </a>
                    </li>

                    @if(Auth::user()->role === 'Admin')
                    <!-- Dropdown Data Master -->
                    <li class="py-2">
                        <button id="mobile-data-master-toggle" class="flex items-center justify-between px-4 py-2 w-full text-left hover:bg-gray-800 rounded">
                            <span class="flex items-center gap-3">
                                <i data-lucide="database"></i> Data Master
                            </span>
                            <i id="mobile-dropdown-icon" data-lucide="chevron-down"></i>
                        </button>
                        <ul id="mobile-data-master-menu" class="hidden pl-6 mt-2 space-y-2">
                            <li><a href="{{ route('admin.students') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded"><i data-lucide="user"></i> Siswa</a></li>
                            <li><a href="{{ route('admin.teachers') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded"><i data-lucide="users"></i> Guru Pembimbing</a></li>
                            <li><a href="{{ route('admin.industries') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded"><i data-lucide="building"></i> Tempat Industri</a></li>
                            <li><a href="{{ route('admin.pkls') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded"><i data-lucide="briefcase"></i> PKL</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </nav>
        </aside>
    </div>

    <script>
        lucide.createIcons();

        document.getElementById("data-master-toggle")?.addEventListener("click", function() {
            document.getElementById("data-master-menu").classList.toggle("hidden");
        });

        document.getElementById("menu-toggle")?.addEventListener("click", function() {
            document.getElementById("mobile-sidebar").classList.remove("hidden");
        });

        document.getElementById("close-sidebar")?.addEventListener("click", function() {
            document.getElementById("mobile-sidebar").classList.add("hidden");
        });

        document.getElementById("mobile-data-master-toggle")?.addEventListener("click", function() {
            document.getElementById("mobile-data-master-menu").classList.toggle("hidden");
        });
    </script>

</body>

</html>