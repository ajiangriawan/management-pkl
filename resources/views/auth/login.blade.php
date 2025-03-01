<x-guest-layout>
    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8">
        <!-- Judul -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-700">Welcome Back!</h2>
            <p class="text-gray-500 text-sm">Please enter your credentials to continue.</p>
        </div>

        <!-- Notifikasi Error -->
        @if ($errors->any())
        <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 border border-red-400 rounded-lg">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Password -->
            <div class="mb-4 relative">
                <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-10">
                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-2 top-8 flex items-center text-gray-600">
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 12a3.75 3.75 0 107.5 0 3.75 3.75 0 00-7.5 0z" />
                    </svg>
                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.5 10.5a3.75 3.75 0 105.25 5.25M15.75 12a3.75 3.75 0 01-7.5 0 3.75 3.75 0 017.5 0zM2.25 12s3.75-7.5 9.75-7.5c1.5 0 3 .25 4.5.75m3.75 6.75s-3.75 7.5-9.75 7.5c-1.5 0-3-.25-4.5-.75" />
                    </svg>
                </button>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex justify-between items-center mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="text-blue-500 border-gray-300 rounded">
                    <span class="ml-2 text-gray-600 text-sm">Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot password?</a>
            </div>

            <!-- Button Login -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-200">
                Log In
            </button>

            <!-- Register Link -->
            <p class="text-sm text-center text-gray-600 mt-4">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Sign up</a>
            </p>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordField.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>