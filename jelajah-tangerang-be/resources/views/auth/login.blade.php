<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - Jelajah Tangerang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-blue-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">

        <div class="w-full md:w-1/2 bg-blue-600 relative hidden md:block">
            <img src="https://images.unsplash.com/photo-1569336415962-a4bd9f69cd83?q=80&w=1931&auto=format&fit=crop"
                alt="Login Illustration"
                class="absolute inset-0 w-full h-full object-cover opacity-80 mix-blend-multiply">

            <div class="relative z-10 flex flex-col justify-center h-full p-12 text-white">
                <h2 class="text-3xl font-bold mb-2">Jelajah Tangerang</h2>
                <p class="text-blue-100">Kelola destinasi wisata dan konten artikel dengan mudah dalam satu pintu.</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12">
            <div class="text-center md:text-left mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Masuk ke akun Anda 👋</h1>
                <p class="text-sm text-gray-500 mt-2">Masukkan detail login untuk mengakses dashboard.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        placeholder="admin@jelajahtangerang.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:text-blue-800 font-medium"
                            href="{{ route('password.request') }}">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                <button type="submit"
                    class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-3 rounded-lg transition duration-300 shadow-lg transform hover:-translate-y-0.5">
                    Masuk Dashboard
                </button>

                <p class="text-center text-xs text-gray-400 mt-6">
                    &copy; {{ date('Y') }} Jelajah Tangerang CMS.
                </p>
            </form>
        </div>
    </div>

</body>

</html>
