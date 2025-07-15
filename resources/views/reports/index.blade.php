@section('title', config('app.name', 'EMisi') . ' - Laporan')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="font-bold">Laporan</h1>
                        <select id="periodFilter" class="border rounded">
                            <option value="" disabled>Filter Periode</option>
                            <option value="">Semua</option>
                            <option value="harian">Harian</option>
                            <option value="bulanan">Bulanan</option>
                            <option value="tahunan">Tahunan</option>
                        </select>
                        <div class="gap-x-4">
                            <x-primary-button x-data="{}" x-on:click="$dispatch('open-modal', 'export-report')"
                                class="w-[150px]">
                                Ekspor Laporan
                            </x-primary-button>
                        </div>
                    </div>
                    <!-- Export Modal with x-modal -->
                    <x-modal name="export-report">
                        <div class="p-6" x-data="{
                            periodType: 'harian',
                            tahun: (new Date()).getFullYear(),
                            bulan: (new Date()).getMonth() + 1,
                            tanggal: (new Date()).toISOString().slice(0,10),
                        }">
                            <h2 class="text-lg font-bold mb-4">Pilih Tipe Laporan</h2>
                            <form method="GET" action="{{ route('reports.export') }}">
                                <div class="mb-4">
                                    <label class="inline-flex items-center mr-4">
                                        <input type="radio" class="form-radio" name="period_type" value="harian" x-model="periodType">
                                        <span class="ml-2">Harian</span>
                                    </label>
                                    <label class="inline-flex items-center mr-4">
                                        <input type="radio" class="form-radio" name="period_type" value="bulanan" x-model="periodType">
                                        <span class="ml-2">Bulanan</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="period_type" value="tahunan" x-model="periodType">
                                        <span class="ml-2">Tahunan</span>
                                    </label>
                                </div>
                                <div class="mb-4">
                                    <template x-if="periodType === 'harian'">
                                        <div>
                                            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                                            <input type="date" id="tanggal" name="tanggal" x-model="tanggal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                    </template>
                                    <template x-if="periodType === 'bulanan'">
                                        <div>
                                            <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                                            <input type="month" id="bulan" name="bulan" :value="tahun + '-' + (bulan < 10 ? '0' + bulan : bulan)" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                    </template>
                                    <template x-if="periodType === 'tahunan'">
                                        <div>
                                            <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                                            <select id="tahun" name="tahun" x-model="tahun" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                <template x-for="y in Array.from({length: 6}, (_, i) => (new Date()).getFullYear() - i)">
                                                    <option :value="y" x-text="y"></option>
                                                </template>
                                            </select>
                                        </div>
                                    </template>
                                </div>
                                <div class="flex justify-end">
                                    <x-primary-button type="submit">Export</x-primary-button>
                                </div>
                            </form>
                        </div>
                    </x-modal>
                    <!-- End Export Modal -->
                    <table class="table-auto w-full mt-4" id="reportTable">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Nama Laporan</th>
                                <th class="px-4 py-2">Tipe Laporan</th>
                                <th class="px-4 py-2">Total CH4</th>
                                <th class="px-4 py-2">Total CO2</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($reports as $report)
                            <tr data-period="{{ $report->period_type }}">
                                <td class="px-4 py-2">{{ $report->report_name }}</td>
                                <td class="px-4 py-2">
                                    @if ($report->period_type == 'harian')
                                    <span class="py-2 px-4 bg-fuchsia-700 text-white rounded-full">Harian</span>
                                    @elseif ($report->period_type == 'bulanan')
                                    <span class="py-2 px-4 bg-blue-700 text-white rounded-full">Bulanan</span>
                                    @elseif ($report->period_type == 'tahunan')
                                    <span class="py-2 px-4 bg-cyan-700 text-white rounded-full">Tahunan</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $report->total_ch4 }}</td>
                                <td class="px-4 py-2">{{ $report->total_co2 }}</td>
                                <td class="px-4 py-2">
                                    <a href="/report/{{ $report->id }}">
                                        <x-primary-button>View</x-primary-button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <script>
                        document.getElementById('periodFilter').addEventListener('change', function() {
                            var value = this.value;
                            var rows = document.querySelectorAll('#reportTable tbody tr');
                            rows.forEach(function(row) {
                                if (!value || row.getAttribute('data-period') === value) {
                                    row.style.display = '';
                                } else {
                                    row.style.display = 'none';
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
    </div>


</x-app-layout>