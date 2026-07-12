@extends('layouts.app')

@section('title', 'Laporan')
@section('header', '📊 Reports Central')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Deskripsi -->
    <div class="mb-6">
        <p class="text-gray-600">Generate and analyze health data across all monitored categories.</p>
    </div>

    <!-- ===== FILTER ===== -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 mb-6 transition hover:shadow-xl">
        <form action="{{ route('laporan.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">DATE RANGE</label>
                    <select name="date_range" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                        <option value="30">Last 30 Days</option>
                        <option value="7">Last 7 Days</option>
                        <option value="90">Last 90 Days</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">VILLAGE/AREA</label>
                    <select name="posyandu_id" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                        <option value="">All Locations</option>
                        @foreach($posyandus as $p)
                            <option value="{{ $p->id }}" {{ request('posyandu_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_posyandu }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">STATUS GROUP</label>
                    <select name="status_group" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                        <option value="all">All Statuses</option>
                        <option value="stunting">Stunting</option>
                        <option value="normal">Normal</option>
                        <option value="underweight">Underweight</option>
                        <option value="wasting">Wasting</option>
                    </select>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 mt-4">
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
                <a href="{{ route('laporan.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium px-4 py-2.5 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-undo"></i> Reset
                </a>
                <a href="{{ route('laporan.exportPDF', request()->all()) }}" class="bg-red-500 hover:bg-red-600 text-white font-medium px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
            </div>
        </form>
    </div>

    <!-- ===== KARTU LAPORAN ===== -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 transition hover:shadow-xl">
            <div class="flex items-start justify-between">
                <div>
                    <h4 class="font-semibold text-gray-800">Stunting Recapitulation</h4>
                    <p class="text-xs text-gray-500 mt-1">Complete overview of child growth status and nutritional trends across the district.</p>
                </div>
                <i class="fas fa-chart-bar text-pink-500 text-2xl"></i>
            </div>
            <a href="#" class="inline-block mt-3 text-pink-500 hover:text-pink-700 text-sm font-medium transition">View Report →</a>
        </div>
        <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 transition hover:shadow-xl">
            <div class="flex items-start justify-between">
                <div>
                    <h4 class="font-semibold text-gray-800">Monthly Progress</h4>
                    <p class="text-xs text-gray-500 mt-1">Comparison of growth metrics from the current month vs. the previous monitoring period.</p>
                </div>
                <i class="fas fa-chart-line text-pink-500 text-2xl"></i>
            </div>
            <a href="#" class="inline-block mt-3 text-pink-500 hover:text-pink-700 text-sm font-medium transition">View Report →</a>
        </div>
        <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 transition hover:shadow-xl">
            <div class="flex items-start justify-between">
                <div>
                    <h4 class="font-semibold text-gray-800">Maternal Nutrition Log</h4>
                    <p class="text-xs text-gray-500 mt-1">Detailed tracking of prenatal vitamins, weight gain, and nutritional intake for pregnant women.</p>
                </div>
                <i class="fas fa-female text-pink-500 text-2xl"></i>
            </div>
            <a href="#" class="inline-block mt-3 text-pink-500 hover:text-pink-700 text-sm font-medium transition">View Report →</a>
        </div>
        <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 transition hover:shadow-xl">
            <div class="flex items-start justify-between">
                <div>
                    <h4 class="font-semibold text-gray-800">Intervention Efficacy</h4>
                    <p class="text-xs text-gray-500 mt-1">Analysis of how specific health interventions have impacted stunting rates over time.</p>
                </div>
                <i class="fas fa-flask text-pink-500 text-2xl"></i>
            </div>
            <a href="#" class="inline-block mt-3 text-pink-500 hover:text-pink-700 text-sm font-medium transition">View Report →</a>
        </div>
    </div>
    <!-- Recent Data Submissions -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/30 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-pink-600">📋 Recent Data Submissions</h3>
            <a href="#" class="text-pink-500 hover:text-pink-700 text-sm font-medium transition">View All Submissions →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-white/20">
                <thead class="bg-pink-100/30 backdrop-blur-sm">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">ID/Patient</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Date Submitted</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Assigned Officer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white/10 backdrop-blur-sm divide-y divide-white/10">
                    @forelse($recentSubmissions ?? [] as $submission)
                    @php
                        $submissionStatus = $submission->status ?? 'Pending';
                        $submissionColor = match($submissionStatus) {
                            'Verified' => 'bg-green-100 text-green-800',
                            'Pending Review' => 'bg-yellow-100 text-yellow-800',
                            'Flagged Error' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800'
                        };

                        $submissionDate = '-';
                        if (!empty($submission->created_at)) {
                            if ($submission->created_at instanceof \DateTimeInterface) {
                                $submissionDate = $submission->created_at->format('M d, Y - h:i A');
                            } elseif (is_string($submission->created_at)) {
                                $submissionDate = \Carbon\Carbon::parse($submission->created_at)->format('M d, Y - h:i A');
                            }
                        }
                    @endphp
                    <tr class="hover:bg-white/20 transition duration-200 {{ $loop->even ? 'bg-white/5' : '' }}">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div>
                                <span class="font-medium text-gray-800">{{ $submission->patient_name ?? 'N/A' }}</span>
                                <span class="text-xs text-gray-500 block">Reg #{{ str_pad($submission->id ?? 0, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-700">{{ $submission->category ?? 'BALITA GROWTH' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-700">{{ $submissionDate }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-700">{{ $submission->assigned_officer ?? '-' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $submissionColor }}">{{ $submissionStatus }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500 italic">Belum ada data submission.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 border-t border-white/20 bg-white/10 backdrop-blur-sm flex justify-between items-center text-sm text-gray-600">
            <span>Showing 1-{{ min(10, count($recentSubmissions ?? [])) }} of {{ count($recentSubmissions ?? []) }} entries</span>
            <div class="flex gap-1">
                <a href="#" class="px-3 py-1 bg-white/20 rounded hover:bg-white/30 transition">1</a>
            </div>
        </div>
    </div>

    <!-- ===== FOOTER ===== -->
    <div class="mt-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} SIPANTAU STUNTING MONITOR - HEALTH DATA SYSTEM V2.4.0
    </div>

</div>
@endsection