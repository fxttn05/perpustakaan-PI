<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>C task | Register</title>

    <meta name="title" content="C task - Kelola Tugas dan Catatanmu">

    <meta name="description"
        content="Pengelolaan Perpustakaan SMK Taruna Bhakti Depok">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body class="min-h-screen bg-slate-100">

    <div class="flex min-h-screen flex-col md:flex-row">

        <!-- Left Side -->
        <div class="hidden md:flex md:w-1/2 bg-white items-center justify-center p-10">

            <div class="w-full flex justify-center">
                <img
                    src="{{ asset('logo/SMK_Taruna_Bhakti.webp') }}"
                    alt="Logo"
                    class="w-72 object-contain">
            </div>

        </div>

        <!-- Right Side -->
        <div
            class="w-full md:w-1/2 bg-slate-700 flex items-center justify-center px-6 py-12">

            <div class="w-full max-w-md">

                <h1
                    class="text-5xl md:text-7xl font-bold text-white mb-4">
                    Hello
                </h1>

                <p class="text-slate-200 mb-8">
                    Register untuk membuat akun pengelola
                </p>

                <form
                    action="/registeruser"
                    method="POST"
                    class="space-y-5">

                    @csrf

                    <!-- Nama -->
                    <div>
                        <label
                            for="loginName"
                            class="block text-sm font-medium text-white mb-2">
                            Nama
                        </label>

                        <div class="relative">

                            <input
                                id="loginName"
                                type="text"
                                name="name"
                                placeholder="Masukkan Nama"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 pl-12 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-400">

                            <i
                                class="bi bi-person-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">
                            </i>

                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label
                            for="loginEmail"
                            class="block text-sm font-medium text-white mb-2">
                            Email
                        </label>

                        <div class="relative">

                            <input
                                id="loginEmail"
                                type="email"
                                name="email"
                                placeholder="Masukkan Email"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 pl-12 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-400">

                            <i
                                class="bi bi-envelope-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">
                            </i>

                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label
                            for="loginPassword"
                            class="block text-sm font-medium text-white mb-2">
                            Password
                        </label>

                        <div class="relative">

                            <input
                                id="loginPassword"
                                type="password"
                                name="password"
                                placeholder="Masukkan Password"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 pl-12 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-400">

                            <i
                                class="bi bi-lock-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">
                            </i>

                        </div>
                    </div>

                    <!-- Button -->
                    <button
                        type="submit"
                        class="w-full rounded-xl bg-blue-600 py-3 font-semibold text-white transition hover:bg-blue-700">
                        Register
                    </button>

                </form>

                <!-- Login -->
                <p class="mt-6 text-center text-slate-200">
                    Sudah punya akun?
                    <a
                        href="{{ route('login') }}"
                        class="font-semibold text-white underline hover:text-blue-200">
                        Login
                    </a>
                </p>

            </div>

        </div>

    </div>

</body>

</html>