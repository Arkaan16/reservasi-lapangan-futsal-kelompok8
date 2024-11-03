<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Futsal Reservation</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex items-center justify-center px-4">
        <!-- Register Form Container -->
        <div class="w-full max-w-sm bg-white p-6 rounded-lg shadow-md space-y-4 sm:p-6">
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Logo and Title -->
            <div class="text-center">
                <img src="/assets/img/logof.png" alt="Futsal Logo" class="w-12 mx-auto mb-3">
                <h1 class="text-lg font-semibold text-gray-800">Create Account</h1>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input id="name" name="name" type="text" :value="old('name')" required autocomplete="name" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <!-- Error Message -->
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email" :value="old('email')" required autocomplete="email" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <!-- Error Message -->
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <!-- Error Message -->
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <!-- Error Message -->
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Register Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition duration-300">Register</button>
                </div>
            </form>

            <!-- Already Registered Link -->
            <p class="text-center text-sm text-gray-600 mt-4">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login here</a>
            </p>
        </div>
    </div>

</body>
</html>