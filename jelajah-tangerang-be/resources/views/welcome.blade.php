<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Portal - Jelajah Tangerang</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-gray-50">

    <div class="min-h-screen flex">

        <div class="hidden lg:flex w-1/2 bg-blue-900 items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-40 bg-cover bg-center"
                style="background-image: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
            </div>

            <div class="relative z-10 text-center px-10">
                <h2 class="text-4xl font-bold text-white mb-4 tracking-wide">JELAJAH TANGERANG</h2>
                <p class="text-blue-100 text-lg">Sistem Informasi Manajemen Data Wisata & Konten</p>
                <div class="mt-8 border-t border-blue-400 w-24 mx-auto"></div>
                <p class="mt-8 text-sm text-blue-200">Kelola Destinasi, Artikel, dan Review dalam satu pintu.</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="max-w-md w-full">

                <div class="lg:hidden text-center mb-8">
                    <h2 class="text-3xl font-bold text-blue-900">JELAJAH TANGERANG</h2>
                    <p class="text-gray-500">Admin Portal</p>
                </div>

                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang, Admin! 👋</h1>
                    <p class="text-gray-500">Silakan login untuk mengakses panel kontrol.</p>
                </div>

                <div class="space-y-4">
                    @if (Route::has('login'))
                        @auth
                            <div class="text-center">
                                <div class="p-4 bg-green-50 text-green-700 rounded-lg mb-6 border border-green-200">
                                    Halo, <strong>{{ Auth::user()->name }}</strong>!<br>
                                    <span class="text-xs text-green-600">Sesi Anda masih aktif.</span>
                                </div>
                                <a href="{{ url('/dashboard') }}"
                                    class="block w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:-translate-y-1">
                                    Lanjut ke Dashboard 🚀
                                </a>
                            </div>
                        @else
                            <div class="grid gap-4">
                                <a href="{{ route('login') }}"
                                    class="flex items-center justify-center w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    Masuk ke Sistem
                                </a>

                                <div class="mt-4 text-center">
                                    <p class="text-sm text-gray-400">
                                        <i class="align-middle" data-feather="lock"></i>
                                        Akses terbatas hanya untuk Staff & Editor.
                                    </p>
                                </div>
                            </div>
                        @endauth
                    @endif
                </div>

                <div class="mt-12 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} MS - JelajahTangerang.<br>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
