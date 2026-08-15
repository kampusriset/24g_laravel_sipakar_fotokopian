<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - PUNAZA COPY</title>
    <!-- Tailwind CSS & Bootstrap Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        .register-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }
        .btn-amber {
            background-color: #d97706 !important;
            color: #ffffff !important;
        }
        .btn-amber:hover {
            background-color: #b45309 !important;
        }
    </style>
</head>
<body class="register-bg min-h-screen flex items-center justify-center p-4">

    <!-- Container Utama Layout Split Card -->
    <div class="max-w-4xl w-full bg-slate-900/90 border border-slate-700/80 rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">
        
        <!-- SISI KIRI: Banner / Branding Percetakan -->
        <div class="bg-gradient-to-br from-amber-600 to-orange-700 p-8 md:p-12 flex flex-col justify-between text-white relative overflow-hidden">
            <!-- Pattern Hiasan Background -->
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 bg-black/20 px-3.5 py-1.5 rounded-full text-xs font-bold border border-white/20 mb-6">
                    <span>🖨️</span> PUNAZA COPY
                </div>
                <h2 class="text-3xl font-black leading-tight mb-3">
                    Bergabung Sekarang!
                </h2>
                <p class="text-amber-100/90 text-sm leading-relaxed">
                    Buat akun untuk mempermudah transaksi cetak dokumen, memantau antrean secara langsung, dan mendapatkan estimasi waktu pengerjaan yang transparan.
                </p>
            </div>

            <!-- List Keuntungan Akun -->
            <div class="relative z-10 space-y-3 my-6">
                <div class="flex items-center gap-3 text-xs font-semibold bg-white/10 p-2.5 rounded-xl border border-white/10">
                    <span class="text-lg">📋</span> Pantau Status Pesanan Real-Time
                </div>
                <div class="flex items-center gap-3 text-xs font-semibold bg-white/10 p-2.5 rounded-xl border border-white/10">
                    <span class="text-lg">🧾</span> Unduh Nota Cetak Kapan Saja
                </div>
            </div>

            <div class="relative z-10 text-xs text-amber-200/80">
                &copy; {{ date('Y') }} Punaza Copy. All rights reserved.
            </div>
        </div>

        <!-- SISI KANAN: Form Register -->
        <div class="p-8 md:p-12 flex flex-col justify-center bg-slate-900">
            <div class="mb-6">
                <h3 class="text-2xl font-extrabold text-white">Buat Akun Baru ✨</h3>
                <p class="text-slate-400 text-xs mt-1">Lengkapi data di bawah ini untuk mendaftar.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-2.5 text-slate-400"><i class="bi bi-person"></i></span>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                               placeholder="Nama kamu..."
                               class="w-full pl-10 pr-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                        Email
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-2.5 text-slate-400"><i class="bi bi-envelope"></i></span>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                               placeholder="nama@email.com"
                               class="w-full pl-10 pr-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-2.5 text-slate-400"><i class="bi bi-lock"></i></span>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-2.5 text-slate-400"><i class="bi bi-shield-lock"></i></span>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full btn-amber py-2.5 rounded-xl font-bold text-sm shadow-lg transition transform hover:-translate-y-0.5 mt-2">
                    Daftar Akun Sekarang 🚀
                </button>
            </form>

            <!-- Link Kembali ke Login -->
            <div class="mt-5 border-t border-slate-800 pt-4 text-center">
                <p class="text-xs text-slate-400 mb-2">Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="inline-block text-xs font-bold text-amber-400 hover:text-amber-300 border border-amber-500/30 bg-amber-500/10 px-4 py-2 rounded-xl transition">
                    Masuk ke Akun
                </a>
            </div>

        </div>

    </div>

</body>
</html>