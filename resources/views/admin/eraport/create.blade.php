@extends('admin.layout')

@section('title', 'Input Rapor Siswa')

@section('content')
<div class="max-w-5xl mx-auto pb-20"> <div class="sticky top-4 z-40 mb-8 animate-slide-down">
        <div class="bg-slate-900/90 backdrop-blur-md p-4 rounded-2xl border border-slate-700 shadow-2xl flex flex-col md:flex-row items-center justify-between gap-4">

            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="w-12 h-12 rounded-full bg-slate-800 border border-slate-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-user-graduate text-2xl text-orange-500"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white leading-tight">Input Rapor</h1>
                    <p class="text-slate-400 text-sm flex items-center gap-2">
                        Siswa: <span class="text-orange-400 font-bold bg-orange-500/10 px-2 rounded">{{ $user->name }}</span>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-slate-800 px-5 py-2 rounded-xl border border-slate-700 w-full md:w-auto justify-between md:justify-end">
                <div class="text-right">
                    <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold mb-1">Live Score</p>
                    <div class="flex items-baseline justify-end gap-1">
                        <span class="text-3xl font-black text-white transition-colors duration-300" id="displayAverage">0.0</span>
                        <span class="text-xs text-slate-500">/100</span>
                    </div>
                </div>
                <div class="h-10 w-1 bg-gradient-to-b from-orange-500 to-red-500 rounded-full"></div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.eraport.store', $user->id) }}" class="space-y-8 animate-fade-in-up">
        @csrf
        <input type="hidden" name="average_score" id="inputAverage">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl relative overflow-hidden group hover:border-orange-500/30 transition-colors">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-500 to-red-500"></div>

                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-orange-500/20 text-orange-500 flex items-center justify-center">
                        <i class="fa-solid fa-bolt"></i>
                    </span>
                    Aspek Fisik
                </h2>

                <div class="space-y-5">
                    <div>
                        <label class="block text-slate-400 text-xs font-bold uppercase mb-2 ml-1">Agility (Kelincahan)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-wind text-slate-500"></i>
                            </div>
                            <input type="number" name="agility" min="0" max="100" placeholder="0" required
                                class="score-input w-full bg-slate-800 text-white pl-12 pr-4 py-3 rounded-xl border border-slate-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent font-bold text-lg placeholder-slate-600 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-400 text-xs font-bold uppercase mb-2 ml-1">Speed (Kecepatan)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-gauge-high text-slate-500"></i>
                            </div>
                            <input type="number" name="speed" min="0" max="100" placeholder="0" required
                                class="score-input w-full bg-slate-800 text-white pl-12 pr-4 py-3 rounded-xl border border-slate-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent font-bold text-lg placeholder-slate-600 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-400 text-xs font-bold uppercase mb-2 ml-1">Stamina (Daya Tahan)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-heart-pulse text-slate-500"></i>
                            </div>
                            <input type="number" name="stamina" min="0" max="100" placeholder="0" required
                                class="score-input w-full bg-slate-800 text-white pl-12 pr-4 py-3 rounded-xl border border-slate-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent font-bold text-lg placeholder-slate-600 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-400 text-xs font-bold uppercase mb-2 ml-1">Strength (Kekuatan)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-dumbbell text-slate-500"></i>
                            </div>
                            <input type="number" name="strength" min="0" max="100" placeholder="0" required
                                class="score-input w-full bg-slate-800 text-white pl-12 pr-4 py-3 rounded-xl border border-slate-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent font-bold text-lg placeholder-slate-600 transition-all">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl relative overflow-hidden group hover:border-blue-500/30 transition-colors">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-cyan-500"></div>

                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-blue-500/20 text-blue-500 flex items-center justify-center">
                        <i class="fa-regular fa-futbol"></i>
                    </span>
                    Aspek Teknik
                </h2>

                <div class="space-y-5">
                    <div>
                        <label class="block text-slate-400 text-xs font-bold uppercase mb-2 ml-1">Passing</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-share nodes text-slate-500"></i>
                            </div>
                            <input type="number" name="passing" min="0" max="100" placeholder="0" required
                                class="score-input w-full bg-slate-800 text-white pl-12 pr-4 py-3 rounded-xl border border-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent font-bold text-lg placeholder-slate-600 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-400 text-xs font-bold uppercase mb-2 ml-1">Dribbling</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-shoe-prints text-slate-500"></i>
                            </div>
                            <input type="number" name="dribbling" min="0" max="100" placeholder="0" required
                                class="score-input w-full bg-slate-800 text-white pl-12 pr-4 py-3 rounded-xl border border-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent font-bold text-lg placeholder-slate-600 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-400 text-xs font-bold uppercase mb-2 ml-1">Shooting</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-crosshairs text-slate-500"></i>
                            </div>
                            <input type="number" name="shooting" min="0" max="100" placeholder="0" required
                                class="score-input w-full bg-slate-800 text-white pl-12 pr-4 py-3 rounded-xl border border-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent font-bold text-lg placeholder-slate-600 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-400 text-xs font-bold uppercase mb-2 ml-1">Defending</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-shield-halved text-slate-500"></i>
                            </div>
                            <input type="number" name="defending" min="0" max="100" placeholder="0" required
                                class="score-input w-full bg-slate-800 text-white pl-12 pr-4 py-3 rounded-xl border border-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent font-bold text-lg placeholder-slate-600 transition-all">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl relative overflow-hidden group hover:border-green-500/30 transition-colors">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-emerald-500"></div>

            <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                <span class="w-8 h-8 rounded-lg bg-green-500/20 text-green-500 flex items-center justify-center">
                    <i class="fa-solid fa-clipboard-check"></i>
                </span>
                Evaluasi & Catatan Coach
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="flex items-center gap-2 text-green-400 text-sm font-bold uppercase mb-2 ml-1">
                        <i class="fa-solid fa-thumbs-up"></i> Kelebihan (Strength)
                    </label>
                    <textarea name="strength_note" rows="4"
                        class="w-full rounded-xl bg-slate-800 border border-slate-700 text-white p-4 focus:ring-2 focus:ring-green-500 focus:border-transparent leading-relaxed placeholder-slate-600"
                        placeholder="Tuliskan poin-poin keunggulan siswa..."></textarea>
                </div>

                <div>
                    <label class="flex items-center gap-2 text-red-400 text-sm font-bold uppercase mb-2 ml-1">
                        <i class="fa-solid fa-triangle-exclamation"></i> Evaluasi (Improvement)
                    </label>
                    <textarea name="weakness_note" rows="4"
                        class="w-full rounded-xl bg-slate-800 border border-slate-700 text-white p-4 focus:ring-2 focus:ring-red-500 focus:border-transparent leading-relaxed placeholder-slate-600"
                        placeholder="Apa yang perlu diperbaiki kedepannya..."></textarea>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-800">
                <label class="flex items-center gap-2 text-yellow-400 text-sm font-bold uppercase mb-2 ml-1">
                    <i class="fa-regular fa-lightbulb"></i> Catatan Tambahan (Opsional)
                </label>
                <textarea name="general_note" rows="2"
                    class="w-full rounded-xl bg-slate-800 border border-slate-700 text-white p-4 focus:ring-2 focus:ring-yellow-500 focus:border-transparent leading-relaxed placeholder-slate-600"
                    placeholder="Contoh: Attitude latihan sangat baik, perlu dipertahankan..."></textarea>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit"
                class="group w-full bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-orange-900/20 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 text-lg">
                <i class="fa-solid fa-paper-plane group-hover:animate-pulse"></i>
                Terbitkan Rapor Sekarang
            </button>
        </div>

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.score-input');
        const displayAvg = document.getElementById('displayAverage');
        const inputAvg = document.getElementById('inputAverage');

        function calculateAverage() {
            let total = 0;
            let count = 0;

            inputs.forEach(input => {
                const val = parseFloat(input.value);
                if (!isNaN(val)) {
                    total += val;
                    count++;
                }
            });

            // Hitung rata-rata
            const average = count > 0 ? (total / count).toFixed(1) : 0;

            // Update Tampilan & Input Hidden
            displayAvg.innerText = average;
            inputAvg.value = average;

            // Efek warna visual pada angka
            // Reset class warna
            displayAvg.classList.remove('text-white', 'text-green-400', 'text-yellow-400', 'text-red-400');

            if(average >= 85) {
                displayAvg.classList.add('text-green-400');
            } else if(average >= 70) {
                displayAvg.classList.add('text-yellow-400');
            } else if(average > 0) {
                displayAvg.classList.add('text-red-400');
            } else {
                displayAvg.classList.add('text-white');
            }
        }

        inputs.forEach(input => {
            input.addEventListener('input', calculateAverage);
        });
    });
</script>
@endsection
