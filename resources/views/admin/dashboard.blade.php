@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4 animate-fade-in-down">
        <div>
            <h1 class="text-4xl font-bold text-white flex items-center gap-3">
                <i class="fa-solid fa-gauge-high"></i>
                Admin Dashboard
            </h1>
            <p class="text-slate-400 mt-2 text-lg">
                Overview performa sistem & statistik pengguna.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-4 py-2 rounded-xl bg-orange-500/10 border border-orange-500/20 text-orange-400 text-sm font-semibold flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                SYSTEM ONLINE
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">

        <div class="relative overflow-hidden rounded-2xl bg-slate-900 border border-slate-800 p-6 group hover:border-orange-500/30 transition-all duration-300">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-users text-4xl text-orange-400"></i>
            </div>
            <p class="text-slate-400 text-sm font-medium">Total Pengguna</p>
            <h2 class="text-4xl font-bold mt-2 text-white group-hover:text-orange-400 transition-colors">
                {{ number_format($totalUser ?? 0) }}
            </h2>
            <p class="text-xs text-slate-500 mt-2">Terdaftar di database</p>
        </div>

        <div class="relative overflow-hidden rounded-2xl bg-slate-900 border border-slate-800 p-6 group hover:border-green-500/30 transition-all duration-300">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-user-plus text-4xl text-green-400"></i>
            </div>
            <p class="text-slate-400 text-sm font-medium">Pengguna Baru (Hari Ini)</p>
            <h2 class="text-4xl font-bold mt-2 text-white group-hover:text-green-400 transition-colors">
                +{{ number_format($userToday ?? 0) }}
            </h2>
            <p class="text-xs text-slate-500 mt-2">Perlu verifikasi / review</p>
        </div>

        <div class="relative overflow-hidden rounded-2xl bg-slate-900 border border-slate-800 p-6 group hover:border-blue-500/30 transition-all duration-300">
    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
        <i class="fa-solid fa-chart-line text-4xl text-blue-400"></i>
    </div>
    <p class="text-slate-400 text-sm font-medium">Active Sessions</p>

    {{-- Update bagian ini dengan variabel Blade --}}
    <h2 class="text-4xl font-bold mt-2 text-white group-hover:text-blue-400 transition-colors">
        {{ $activeSessions }}
    </h2>

    <p class="text-xs text-slate-500 mt-2">Real-time monitoring (Last 10m)</p>
</div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 rounded-2xl bg-slate-900 border border-slate-800 p-6 shadow-xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <span class="w-1 h-6 bg-orange-500 rounded-full"></span>
                    Statistik Pendaftaran (7 Hari)
                </h3>
            </div>
            <div class="relative h-80 w-full">
                <canvas id="userChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-1 rounded-2xl bg-slate-900 border border-slate-800 p-6 shadow-xl flex flex-col">
            <h3 class="text-lg font-semibold text-white mb-6 flex items-center gap-2">
                <span class="w-1 h-6 bg-blue-500 rounded-full"></span>
                Distribusi Role User
            </h3>
            <div class="relative h-64 w-full flex-grow flex items-center justify-center">
                <canvas id="roleChart"></canvas>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
{{-- Pastikan Chart.js diload --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // --- SETUP DATA ---
    const userLabels = @json($usersPerDay?->pluck('date') ?? []);
    const userData   = @json($usersPerDay?->pluck('total') ?? []);

    // Fallback jika data kosong agar chart tidak error
    if (userLabels.length === 0) {
        userLabels.push('No Data');
        userData.push(0);
    }

    const roleLabels = @json($roleCount?->keys() ?? []);
    const roleData   = @json($roleCount?->values() ?? []);

    // --- CONFIG COMMON ---
    Chart.defaults.color = '#94a3b8'; // Text color slate-400
    Chart.defaults.borderColor = '#1e293b'; // Grid color slate-800

    // --- CHART 1: LINE CHART (User Registration) ---
    const ctxUser = document.getElementById('userChart').getContext('2d');

    // Gradient Fill
    let gradient = ctxUser.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(249, 115, 22, 0.5)'); // Orange pekat
    gradient.addColorStop(1, 'rgba(249, 115, 22, 0.0)'); // Transparan

    new Chart(ctxUser, {
        type: 'line',
        data: {
            labels: userLabels,
            datasets: [{
                label: 'User Baru',
                data: userData,
                borderColor: '#f97316',
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#f97316',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#fff',
                    bodyColor: '#cbd5e1',
                    borderColor: '#334155',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#1e293b' },
                    ticks: { stepSize: 1 }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // --- CHART 2: DOUGHNUT CHART (Role Distribution) ---
    const backgroundColors = [
        '#f97316', // Orange
        '#093170FF', // Blue
        '#10b981', // Emerald
        '#a855f7', // Purple
        '#ef4444', // Red
    ];

    new Chart(document.getElementById('roleChart'), {
        type: 'doughnut',
        data: {
            labels: roleLabels,
            datasets: [{
                data: roleData,
                backgroundColor: backgroundColors,
                borderColor: '#0f172a',
                borderWidth: 5,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        color: '#94a3b8'
                    }
                }
            },
            cutout: '70%',
        }
    });
</script>
@endpush
