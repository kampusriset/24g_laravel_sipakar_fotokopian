<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PUNAZA COPY</title>
    <!-- Tailwind CSS & Bootstrap Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        .login-bg {
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
<body class="login-bg min-h-screen flex items-center justify-center p-4">

    <!-- Container Utama Layout Split Card -->
    <div class="max-w-4xl w-full bg-slate-900/90 border border-slate-700/80 rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">
        
        <!-- SISI KIRI: Banner / Branding Percetakan Modern -->
        <div class="bg-gradient-to-br from-amber-600 to-orange-700 p-8 md:p-12 flex flex-col justify-between text-white relative overflow-hidden">
            <!-- Pattern Hiasan Background -->
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 bg-black/20 px-3.5 py-1.5 rounded-full text-xs font-bold border border-white/20 mb-6">
                    <span>🖨️</span> PUNAZA COPY
                </div>
                <h2 class="text-3xl font-black leading-tight mb-3">
                    Layanan Cetak Cepat & Terjadwal
                </h2>
                <p class="text-amber-100/90 text-sm leading-relaxed">
                    Nikmati kemudahan pemesanan cetak dokumen dengan estimasi waktu pengerjaan yang presisi dan transparan.
                </p>
            </div>

            <!-- List Fitur Singkat -->
            <div class="relative z-10 space-y-3 my-6">
                <div class="flex items-center gap-3 text-xs font-semibold bg-white/10 p-2.5 rounded-xl border border-white/10">
                    <span class="text-lg">⚡</span> Antrean Otomatis & Cepat
                </div>
                <div class="flex items-center gap-3 text-xs font-semibold bg-white/10 p-2.5 rounded-xl border border-white/10">
                    <span class="text-lg">⏱️</span> Estimasi Selesai Real-Time
                </div>
            </div>

            <div class="relative z-10 text-xs text-amber-200/80">
                &copy; <?php echo e(date('Y')); ?> Punaza Copy. All rights reserved.
            </div>
        </div>

        <!-- SISI KANAN: Form Login -->
        <div class="p-8 md:p-12 flex flex-col justify-center bg-slate-900">
            <div class="mb-6">
                <h3 class="text-2xl font-extrabold text-white">Selamat Datang 👋</h3>
                <p class="text-slate-400 text-xs mt-1">Silakan masuk ke akun Anda untuk melanjutkan.</p>
            </div>

            <!-- Session Status Alert -->
            <?php if (isset($component)) { $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-session-status','data' => ['class' => 'mb-4','status' => session('status')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-session-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4','status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('status'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $attributes = $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $component = $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-3 text-slate-400"><i class="bi bi-envelope"></i></span>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                               placeholder="nama@email.com"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('email'),'class' => 'mt-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('email')),'class' => 'mt-1']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-3 text-slate-400"><i class="bi bi-lock"></i></span>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('password'),'class' => 'mt-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('password')),'class' => 'mt-1']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label for="remember_me" class="inline-flex items-center text-slate-400 cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded bg-slate-800 border-slate-700 text-amber-500 focus:ring-amber-500">
                        <span class="ml-2">Ingat Saya</span>
                    </label>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('password.request')): ?>
                        <a href="<?php echo e(route('password.request')); ?>" class="text-amber-400 hover:text-amber-300 font-semibold transition">
                            Lupa Password?
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full btn-amber py-3 rounded-xl font-bold text-sm shadow-lg transition transform hover:-translate-y-0.5 mt-2">
                    Masuk Sekarang 🚀
                </button>
            </form>

            <!-- Pembatas ATAU -->
            <div class="relative my-4 flex items-center justify-center">
                <div class="border-t border-slate-800 w-full"></div>
                <span class="bg-slate-900 px-3 text-[10px] text-slate-500 font-bold uppercase tracking-wider absolute">Atau</span>
            </div>

            <!-- Tombol Login dengan Google (SUDAH DIHUBUNGKAN KE ROUTE) -->
            <a href="<?php echo e(route('google.login')); ?>" class="w-full bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition shadow-sm">
                <svg class="w-4 h-4" viewBox="0 0 24 24">
                    <path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.6l3.1-3.1C17.3 1.7 14.8 1 12 1 7.5 1 3.7 3.6 1.9 7.3l3.7 2.9C6.5 7.3 9 5 12 5z"/>
                    <path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.8z"/>
                    <path fill="#FBBC05" d="M5.6 14.8c-.2-.7-.4-1.5-.4-2.3s.2-1.6.4-2.3L1.9 7.3C.7 9.7 0 12.3 0 15s.7 5.3 1.9 7.7l3.7-2.9c-.2-.7-.4-1.5-.4-2.3z"/>
                    <path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3 0-5.5-2.3-6.4-5.2L1.9 16c1.8 3.7 5.6 6.3 10.1 6.3z"/>
                </svg>
                Masuk dengan Google
            </a>

            <!-- Register Link -->
            <div class="mt-6 border-t border-slate-800 pt-5 text-center">
                <p class="text-xs text-slate-400 mb-2">Belum punya akun?</p>
                <a href="<?php echo e(route('register')); ?>" class="inline-block text-xs font-bold text-amber-400 hover:text-amber-300 border border-amber-500/30 bg-amber-500/10 px-4 py-2 rounded-xl transition">
                    Daftar Akun Baru
                </a>
            </div>

        </div>

    </div>

</body>
</html><?php /**PATH C:\laragon\www\fotokopi111\resources\views/auth/login.blade.php ENDPATH**/ ?>