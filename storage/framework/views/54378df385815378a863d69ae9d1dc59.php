<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-extrabold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <span>📊</span> <?php echo e(__('Dashboard Pelanggan')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <!-- Custom Style Background & Glassmorphism -->
    <style>
        .dashboard-bg {
            background: linear-gradient(135deg, #cbd5e1 0%, #94a3b8 100%);
            min-height: 100vh;
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.1);
        }

        .hero-banner {
            background: linear-gradient(135deg, #ffffff 0%, #fef3c7 100%);
        }

        /* Tombol Buat Pesanan dipaksa Oranye Menyala & Teks Putih */
        .btn-buat-pesanan {
            background-color: #d97706 !important; /* Oranye Amber Pekat */
            color: #ffffff !important;           /* Teks Putih Tebal */
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.4) !important;
        }

        .btn-buat-pesanan:hover {
            background-color: #b45309 !important; /* Warna Gelap Pas Hover */
        }
    </style>

    <div class="py-8 dashboard-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Banner Utama (Hero Card) -->
            <div class="glass-box hero-banner p-6 border-l-8 border-amber-500 border-t border-r border-b border-amber-200">
                <div class="md:flex md:items-center md:justify-between">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/20 text-amber-900 text-xs font-bold mb-2 border border-amber-300">
                            <span>⚡ PUNAZA COPY AI SYSTEM</span>
                        </div>
                        <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                            Papan Antrean & Status Pesanan 🖨️
                        </h3>
                        <p class="text-slate-600 mt-1 text-sm">
                            Cek perkiraan jam selesai dan status pengerjaan dokumenmu secara real-time.
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <!-- TOMBOL BUAT PESANAN DENGAN WARNA TEGAS -->
                        <a href="<?php echo e(route('order.form')); ?>" 
                           class="btn-buat-pesanan inline-flex items-center gap-2 font-extrabold py-3 px-6 rounded-xl transition transform hover:-translate-y-0.5 text-sm">
                            <span>🖨️</span> + Buat Pesanan Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- TABEL STATUS PELANGGAN -->
            <div class="glass-box p-6 border border-slate-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span>📋</span> Cek Status Pesanan
                    </h3>
                    <span class="text-xs font-semibold text-slate-600 bg-slate-200/80 px-3 py-1 rounded-full border border-slate-300">
                        Diurutkan Berdasarkan Sistem Pakar AI
                    </span>
                </div>

                <!-- FORM PENCARIAN NAMA -->
                <form action="<?php echo e(url('/dashboard')); ?>" method="GET" class="mb-6 flex gap-2">
                    <div class="relative w-full">
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                               placeholder="Ketik nama kamu di sini (contoh: yaya)..." 
                               class="w-full border-slate-300 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm text-sm pl-4 pr-10 py-2.5 bg-white">
                    </div>
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition shadow-sm flex items-center gap-1">
                        <span>🔍</span> Cari
                    </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('search')): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>" class="bg-slate-300 hover:bg-slate-400 text-slate-800 font-bold px-4 py-2.5 rounded-xl text-sm flex items-center transition">
                            Reset
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </form>
                
                <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-100 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3.5">Nama Pemesan</th>
                                <th class="px-4 py-3.5">Detail Pesanan</th>
                                <th class="px-4 py-3.5">Urgensi</th>
                                <th class="px-4 py-3.5">Lama Pengerjaan</th>
                                <th class="px-4 py-3.5">Status Pesanan</th>
                                <th class="px-4 py-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            <?php
                                $query = \App\Models\Order::query();

                                if (request('search')) {
                                    $searchKey = request('search');
                                    $query->where('customer_name', 'like', '%' . $searchKey . '%');
                                }

                                $orders = $query->orderBy('priority_score', 'desc')
                                               ->orderBy('created_at', 'asc')
                                               ->get();
                            ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="hover:bg-amber-50/50 transition">
                                    <td class="px-4 py-4 font-bold text-slate-900">
                                        👤 <?php echo e($order->customer_name); ?>

                                    </td>
                                    <td class="px-4 py-4 font-medium text-slate-800">
                                        📄 <?php echo e($order->total_pages); ?> Hal 
                                        <span class="text-slate-500">(<?php echo e(ucfirst($order->binding_type)); ?>)</span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($order->copies ?? 1) > 1): ?>
                                            <span class="ml-1 px-2 py-0.5 text-xs font-bold rounded bg-amber-100 text-amber-800 border border-amber-200">
                                                <?php echo e($order->copies); ?>x Copy
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-4">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($order->urgency_level ?? 0) >= 8): ?>
                                            <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-red-100 text-red-700 border border-red-200 inline-block">
                                                🔥 Sangat Urgent (<?php echo e($order->urgency_level); ?>/10)
                                            </span>
                                        <?php elseif(($order->urgency_level ?? 0) >= 5): ?>
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200 inline-block">
                                                ⚡ Urgent (<?php echo e($order->urgency_level); ?>/10)
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600 border border-slate-200 inline-block">
                                                ☕ Biasa (<?php echo e($order->urgency_level ?? 1); ?>/10)
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-4 font-semibold text-slate-700">
                                        ⏱️ <?php echo e($order->estimated_duration_minutes ?? 0); ?> Menit
                                    </td>
                                    <td class="px-4 py-4">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status === 'Selesai'): ?>
                                            <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 inline-block">
                                                ✅ Selesai (Bisa Diambil)
                                            </span>
                                        <?php elseif($order->status === 'Diproses'): ?>
                                            <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-blue-100 text-blue-800 border border-blue-200 inline-block">
                                                ⚙️ Sedang Dikerjakan
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-amber-100 text-amber-800 border border-amber-200 inline-block">
                                                ⏳ Dalam Antrean AI
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="<?php echo e(route('order.status', $order->id)); ?>" 
                                           class="inline-flex items-center gap-1 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs px-3 py-1.5 rounded-lg shadow-sm transition">
                                            👁️ Cek Jam & Nota
                                        </a>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-slate-400 font-medium">
                                        🚫 Data pesanan belum ada atau tidak ditemukan.
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\fotokopi111\resources\views/dashboard.blade.php ENDPATH**/ ?>